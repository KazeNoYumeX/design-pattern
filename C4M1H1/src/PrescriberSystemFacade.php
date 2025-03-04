<?php

namespace C4M1H1;

use C4M1H1\FileLoaders\FileType;

class PrescriberSystemFacade
{
    protected PrescriberSystem $prescriberSystem;

    public function __construct(?string $patientsPath, ?string $potentialDiseasesPath)
    {
        $databases = new PatientDatabase($patientsPath, $potentialDiseasesPath);
        $prescriber = new Prescriber($databases);

        $this->setSystem(new PrescriberSystem($prescriber, $databases));
    }

    private function setSystem(PrescriberSystem $prescriberSystem): void
    {
        $this->prescriberSystem = $prescriberSystem;
    }

    private function getSystem(): PrescriberSystem
    {
        return $this->prescriberSystem;
    }

    public function selectPatientById($id): ?Patient
    {
        $system = $this->getSystem();

        return $system->selectPatientById($id);
    }

    public function diagnosis(string $id, array $symptoms, ?FileType $type = null): mixed
    {
        $system = $this->getSystem();

        $system->prescriptionDemand($id, $symptoms);

        $system->diagnosis();

        $data = $system->findDiagnosisById($id);

        if ($type) {
            if (! empty($data)) {
                $data['symptoms'] = $symptoms;
            }

            return $this->save($data, $type);
        }

        return $data;
    }

    public function save(array $data, FileType $CSV): mixed
    {
        $system = $this->getSystem();

        if (empty($data)) {
            echo "無資料\n";

            return null;
        }

        return $system->save($data, $CSV);
    }

    public function createPatientCase(string $id, PatientCase $param): void
    {
        $system = $this->getSystem();

        $system->createPatientCase($id, $param);
    }
}
