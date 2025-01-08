<?php

namespace C3MB;

use C3MB\Units\Unit;

class Troop
{
    public function __construct(
        protected Battle $battle,
        private readonly int $id,
        public array $units = [],
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function addUnit(Unit $unit): void
    {
        $id = count($this->units) + 1;

        // Add the unit to the troop
        $this->units[] = $unit;

        // Set the troop to the unit
        $unit->setTroop($this)
            ->setId($id);
    }

    public function getAliveUnits(): array
    {
        return array_filter($this->units, fn ($unit) => $unit->alive());
    }

    public function annihilated(): bool
    {
        // If anyone is alive, the troop is not annihilated
        foreach ($this->units as $unit) {
            /** @var Unit $unit */
            if ($unit->alive()) {
                return false;
            }
        }

        return true;
    }
}
