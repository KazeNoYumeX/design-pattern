<?php

namespace C3M3H1\CollisionHandlers;

use C3M3H1\MapObjects\FireMapObjects;
use C3M3H1\MapObjects\MapObjects;
use C3M3H1\MapObjects\Obstacle;

readonly class WaterFireCollisionHandler extends CollisionHandler
{
    public function match(MapObjects $former, MapObjects $latter): bool
    {
        return $former instanceof Obstacle && $latter instanceof FireMapObjects ||
            $former instanceof FireMapObjects && $latter instanceof Obstacle;
    }

    public function handleCollision(MapObjects $former, MapObjects $latter): void
    {
        echo "{$former->getSymbol()} and {$latter->getSymbol()} collision, both removed\n";
        $former->remove();
        $latter->remove();
    }
}
