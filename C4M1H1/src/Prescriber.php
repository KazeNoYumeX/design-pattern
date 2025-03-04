<?php

namespace C4M1H1;

use SplQueue;

class Prescriber
{
    public function __construct(
        protected SplQueue $queue,
    ) {}

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

    public function diagnosisDisease(): void {}

    public function diagnosis(): void
    {
        $diagnosis = $this->getNextDemand();

        if (empty($diagnosis)) {
            echo "沒有病人需要診斷\n";

            return;
        }

        echo "病人 ID: {$diagnosis['id']}\n";
        echo '症狀: '.implode(', ', $diagnosis['symptoms'])."\n";

        // 開處方

        // 通知病人
    }
}
