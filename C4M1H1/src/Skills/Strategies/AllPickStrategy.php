<?php

namespace C3MB\Skills\Strategies;

use C3MB\Troop;

readonly class AllPickStrategy extends PickStrategy
{
    public function pickTarget(array $troops): array
    {
        $condition = fn (Troop $troop) => true;

        return $this->troopsToUnits($troops, $condition);
    }
}
