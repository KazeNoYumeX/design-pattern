<?php

namespace C4M1H1;

use C4M1H1\Prescriptions\AntiSnoring;
use C4M1H1\Prescriptions\NRICM101;
use C4M1H1\Prescriptions\Prescription;
use C4M1H1\Prescriptions\PubertyBlocker;
use SplQueue;

class Prescriber
{
    protected ?PrescriberSystem $system;

    public function __construct(
        protected PatientDatabase $database,
        protected SplQueue $queue = new SplQueue,
        protected array $diagnosis = [],
    ) {}

    public function setSystem(PrescriberSystem $system): void
    {
        $this->system = $system;
    }

    public function getSystem(): ?PrescriberSystem
    {
        return $this->system;
    }

    public function prescriptionDemand(string $id, array $symptoms): void
    {
        $this->queue->enqueue([
            'id' => $id,
            'symptoms' => $symptoms,
        ]);
    }

    public function getNextDemand(): array
    {
        if ($this->queue->isEmpty()) {
            return [];
        }

        return $this->queue->dequeue();
    }

    public function diagnosis(): void
    {
        $diagnosis = $this->getNextDemand();

        if (empty($diagnosis)) {
            echo "沒有病人需要診斷\n";

            return;
        }

        // symptoms to array
        ['id' => $id, 'symptoms' => $symptoms] = $diagnosis;
        echo "病人 ID: $id\n";
        echo '症狀: '.implode(', ', $symptoms)."\n";

        $system = $this->getSystem();
        if (empty($system)) {
            echo "系統錯誤\n";

            return;
        }

        $patient = $system->selectPatientById($id);
        if (empty($patient)) {
            echo "找不到病人\n";

            return;
        }

        echo "耗時 3 秒鐘診斷中...\n";

        $prescription = $this->determinePrescription($patient, $symptoms);
        $prescription = $system->supportPrescription($prescription);
        if (empty($prescription)) {
            echo "找不到適合的處方\n";

            return;
        }

        // 通知病人
        $this->diagnosis[] = [
            'id' => $id,
            'prescription' => $prescription,
            'time' => date('Y-m-d H:i:s'),
        ];
    }

    protected function determinePrescription(Patient $patient, array $symptoms): ?Prescription
    {
        if ($patient->bmi() > 26 && in_array('snore', $symptoms)) {
            return new AntiSnoring;
        } elseif ($patient->age() === 18 && $patient->gender() === Gender::FEMALE->value) {
            return new PubertyBlocker;
        } elseif (in_array('sneeze', $symptoms) || in_array('headache', $symptoms) || in_array('cough', $symptoms)) {
            return new NRICM101;
        }

        return null;
    }

    public function findDiagnosisById(string $id): array
    {
        foreach ($this->diagnosis as $diagnosis) {
            if ($diagnosis['id'] === $id) {
                return $diagnosis;
            }
        }

        return [];
    }
}
