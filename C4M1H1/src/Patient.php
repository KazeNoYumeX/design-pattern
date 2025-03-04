<?php

namespace C4M1H1;

use JsonSerializable;

/**
 * @property PatientCase[] $cases
 */
class Patient implements JsonSerializable
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected int $gender,
        protected int $age,
        protected int $height,
        protected int $weight,
        protected array $cases = [],
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function age(): int
    {
        return $this->age;
    }

    public function gender(): int
    {
        return $this->gender;
    }

    public function bmi(): float
    {
        return $this->weight / (($this->height / 100) ** 2);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'gender' => $this->gender,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'cases' => $this->cases,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function addCase(PatientCase $patientCase): void
    {
        $this->cases[] = $patientCase;
    }
}
