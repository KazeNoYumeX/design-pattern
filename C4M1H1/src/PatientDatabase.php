<?php

namespace C4M1H1;

use C4M1H1\FileLoaders\FileLoader;
use C4M1H1\FileLoaders\FileType;

class PatientDatabase
{
    protected array $patients = [];

    protected array $potentialDiseases = [];

    public function __construct(
        private ?string $patientsPath,
        private ?string $potentialDiseasesPath,
        private ?FileLoader $fileLoader = null,
    ) {
        if ($this->fileLoader === null) {
            $this->fileLoader = new FileLoader;
        }

        $this->loadPatients($patientsPath);
        $this->loadPotentialDiseases($potentialDiseasesPath);
    }

    public function selectPatientById(string $id): void
    {
        $patients = $this->patients;

        // Find the patient by ID
        $patient = array_filter($patients, fn ($patient) => $patient['id'] === $id);
        $patient = array_shift($patient);
        if (! $patient) {
            echo "找不到病人\n";

            return;
        }

        $patient = new Patient(
            $patient['id'],
            $patient['name'],
            $patient['gender'],
            $patient['age'],
            $patient['height'],
            $patient['weight'],
            $patient['cases'],
        );

        $this->showPatient($patient);
    }

    public function insertPatient(Patient $patient): void
    {
        $this->patients[] = $patient;

        echo "新增病人成功\n";

        // save the patients to the file
        $this->fileLoader->saveFile(FileType::JSON, $this->patientsPath, $this->patients);
    }

    private function loadPatients(?string $patientsPath): void
    {
        if (! $patientsPath) {
            return;
        }

        $type = $this->pathToType($patientsPath);
        $this->patients = $this->fileLoader->loadFile($type, $patientsPath);
    }

    private function pathToType(string $path): FileType
    {
        // Get Path file extension
        $type = pathinfo($path, PATHINFO_EXTENSION);

        return FileType::tryFrom($type);
    }

    private function loadPotentialDiseases(?string $potentialDiseasesPath): void
    {
        if (! $potentialDiseasesPath) {
            return;
        }

        $type = $this->pathToType($potentialDiseasesPath);
        $this->potentialDiseases = $this->fileLoader->loadFile($type, $potentialDiseasesPath);
    }

    private function showPatient(Patient $patient): void
    {
        echo "病人資料\n";

        $params = $patient->toArray();
        foreach ($params as $key => $value) {
            if (is_array($value)) {
                echo "$key: ".implode(', ', $value)."\n";
            } else {
                echo "$key: $value\n";
            }
        }
    }
}
