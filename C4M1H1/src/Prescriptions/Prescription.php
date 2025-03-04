<?php

namespace C4M1H1\Prescriptions;

use JsonSerializable;

class Prescription implements JsonSerializable
{
    public function __construct(
        public string $name,
        public string $potentialDisease,
        public string $diseaseScientificName,
        public string $medicines,
        public string $usage,
    ) {}

    public function diseaseScientificName(): string
    {
        return $this->diseaseScientificName;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'potentialDisease' => $this->potentialDisease,
            'diseaseScientificName' => $this->diseaseScientificName,
            'medicines' => $this->medicines,
            'usage' => $this->usage,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
