<?php

namespace C4M1H1;

use C4M1H1\FileLoaders\FileLoader;
use C4M1H1\FileLoaders\FileType;
use C4M1H1\Prescriptions\Prescription;

class PatientDatabase
{
    protected array $patients = [];

    protected array $potentialDiseases = [];

    public function __construct(
        private readonly ?string $patientsPath,
        private readonly ?string $potentialDiseasesPath,
        private readonly ?FileLoader $fileLoader = new FileLoader,
    ) {
        $this->loadPatients($this->patientsPath);
        $this->loadPotentialDiseases($this->potentialDiseasesPath);
    }

    public function getPatients(): array
    {
        return $this->patients;
    }

    public function selectPatientById(string $id): ?Patient
    {
        $patients = $this->getPatients();

        // Find the patient by ID
        $patient = array_filter($patients, fn ($patient) => $patient['id'] === $id);
        $patient = array_shift($patient);
        if (! $patient) {
            echo "找不到病人\n";

            return null;
        }

        return new Patient(
            $patient['id'],
            $patient['name'],
            $patient['gender'],
            $patient['age'],
            $patient['height'],
            $patient['weight'],
            $patient['cases'],
        );
    }

    private function loadData(?string $path, string $property): void
    {
        if (! $path) {
            return;
        }

        $type = $this->pathToType($path);
        $this->$property = $this->fileLoader->loadFile($type, $path);
    }

    private function loadPatients(?string $patientsPath): void
    {
        $this->loadData($patientsPath, 'patients');
    }

    private function loadPotentialDiseases(?string $potentialDiseasesPath): void
    {
        $this->loadData($potentialDiseasesPath, 'potentialDiseases');
    }

    private function pathToType(string $path): FileType
    {
        // Get Path file extension
        $type = pathinfo($path, PATHINFO_EXTENSION);

        return FileType::tryFrom($type);
    }

    public function createPatientCase(string $id, PatientCase $patientCase, FileType $type): void
    {
        $patient = $this->selectPatientById($id);
        if (! $patient) {
            return;
        }

        $patient->addCase($patientCase);
        $this->updatePatient($patient);

        echo "新增病例成功\n";

        // save the patients to the file
        $this->fileLoader->saveFile($type, $this->patientsPath, $this->patients);
    }

    private function updatePatient(Patient $patient): void
    {
        $patients = $this->getPatients();

        // Find the patient by ID
        $key = array_search($patient->id(), array_column($patients, 'id'));
        if ($key === false) {
            return;
        }

        $patients[$key] = $patient->toArray();
        $this->patients = $patients;
    }

    public function formatData(array $params, FileType $type): mixed
    {
        return $this->fileLoader->formatDataByType($params, $type);
    }

    public function potentialDiseases(): array
    {
        return $this->potentialDiseases;
    }

    public function supportPrescription(Prescription $prescription): ?Prescription
    {
        $scientificName = $prescription->diseaseScientificName();
        $potentialDiseases = $this->potentialDiseases();

        // Find the prescription by name
        $potentialDisease = array_filter($potentialDiseases, fn ($disease) => $disease === $scientificName);
        $potentialDisease = array_shift($potentialDisease);
        if (! $potentialDisease) {
            return null;
        }

        return $prescription;
    }
}
