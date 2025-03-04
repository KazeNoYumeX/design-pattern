<?php

namespace C4M1H1\States;

use C4M1H1\Prescription;

class Poisoned extends Prescription
{
    public function __construct(
        protected int $duration = 3,
    ) {
        parent::__construct('中毒', $duration);
    }

    public function onTakeAction(array $actions): array
    {
        $this->unit?->damage(15);

        return parent::onTakeAction($actions);
    }
}
