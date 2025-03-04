<?php

namespace C4M1H1;

use JsonSerializable;

class PatientCase implements JsonSerializable
{
    public function __construct(
        protected string $name,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
