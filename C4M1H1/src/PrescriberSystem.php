<?php

namespace C4M1H1;

use C4M1H1\FileLoaders\FileType;
use C4M1H1\Prescriptions\Prescription;

class PrescriberSystem
{
    public function __construct(
        protected Prescriber $prescriber,
        protected PatientDatabase $database,
    ) {
        $this->prescriber->setSystem($this);
    }

    public function save(array $params, FileType $type): mixed
    {
        ['id' => $id, 'symptoms' => $symptoms, 'time' => $time, 'prescription' => $prescription] = $params;
        $patientCase = new PatientCase($time, $symptoms, $prescription);
        $this->createPatientCase($id, $patientCase);

        return $this->database->formatData($patientCase->toArray(), $type);
    }

    public function createPatientCase(string $id, PatientCase $patientCase, FileType $type = FileType::JSON): void
    {
        $this->database->createPatientCase($id, $patientCase, $type);
    }

    public function prescriptionDemand(string $id, array $symptoms): void
    {
        $this->prescriber->prescriptionDemand($id, $symptoms);
    }

    public function diagnosis(): void
    {
        $this->prescriber->diagnosis();
    }

    public function findDiagnosisById(string $id): array
    {
        return $this->prescriber->findDiagnosisById($id);
    }

    public function selectPatientById(string $id): ?Patient
    {
        return $this->database->selectPatientById($id);
    }

    public function supportPrescription(?Prescription $prescription): ?Prescription
    {
        if (empty($prescription)) {
            return null;
        }

        return $this->database->supportPrescription($prescription);
    }
}
