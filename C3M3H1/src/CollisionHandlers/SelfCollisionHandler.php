<?php

namespace C3M3H1\CollisionHandlers;

use C3M3H1\MapObjects\MapObjects;

readonly class SelfCollisionHandler extends CollisionHandler
{
    public function match(MapObjects $former, MapObjects $latter): bool
    {
        return $former instanceof $latter;
    }

    public function handleCollision(MapObjects $former, MapObjects $latter): void
    {
        echo "{$former->getSymbol()} to {$latter->getSymbol()} same type collision, move failed\n";
    }
}
