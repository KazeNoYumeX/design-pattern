<?php

namespace C3MB\Skills\Strategies;

use C3MB\Skills\Action;
use C3MB\Troop;

abstract readonly class PickStrategy
{
    public function __construct(protected Action $action) {}

    abstract public function pickTarget(array $troops): array;

    protected function troopsToUnits(array $troops, callable $condition): array
    {
        $troops = array_filter($troops, $condition);

        $enemies = [];

        /** @var Troop $troop */
        foreach ($troops as $troop) {
            $enemies = array_merge($enemies, $troop->getAliveUnits());
        }

        return $enemies;
    }
}
