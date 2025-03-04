<?php

namespace C4M1H1;

use C4M1H1\Prescriptions\Prescription;
use JsonSerializable;

class PatientCase implements JsonSerializable
{
    public function __construct(
        protected string $castTime,
        protected array $symptoms,
        protected Prescription $prescription,
    ) {}

    public function toArray(): array
    {
        return [
            'castTime' => $this->castTime,
            'symptoms' => implode(', ', $this->symptoms),
            'prescription' => $this->prescription->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
