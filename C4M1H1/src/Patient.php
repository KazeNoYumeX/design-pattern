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
}
