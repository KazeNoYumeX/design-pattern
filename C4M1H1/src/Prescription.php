<?php

namespace C4M1H1;

use C4M1H1\FileLoaders\Unit;
use C4M1H1\States\Normal;

abstract class Prescription
{
    public function __construct(
        public string $name,
    ) {}

    public function onTakeAction(array $actions): array
    {
        return $actions;
    }

    public function onAttack(int $damage = 0): int
    {
        return $damage;
    }

    public function onEndAction(): void
    {
        $this->duration--;

        if ($this->duration <= 0) {
            $this->exitState();
        }
    }

    public function exitState(): void
    {
        $this->unit?->enterState(new Normal);
    }

    public function enterState(Unit $role): static
    {
        $this->setUnit($role);

        return $this;
    }

    public function setUnit(Unit $unit): void
    {
        $this->unit = $unit;
    }

    public function onHeal(int $heal): int
    {
        return $heal;
    }
}
