<?php

namespace C3MB\Skills\Strategies;

use C3MB\Troop;

readonly class AllyPickStrategy extends PickStrategy
{
    public function pickTarget(array $troops): array
    {
        $action = $this->action;
        $executor = $action->getExecutor();

        $condition = fn (Troop $troop) => $troop->getId() === $executor->getTroopId();
        $units = $this->troopsToUnits($troops, $condition);

        $pickNumber = $action->getNumber();
        if ($pickNumber === 0) {
            $pickNumber = count($units);
        }

        return $executor->chooseTarget($units, $pickNumber);
    }
}
