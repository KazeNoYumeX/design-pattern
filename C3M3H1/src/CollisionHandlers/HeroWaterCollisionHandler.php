<?php

namespace C3M3H1\CollisionHandlers;

use C3M3H1\MapObjects\Treasure;
use C3M3H1\MapObjects\MapObjects;
use C3M3H1\MapObjects\Obstacle;

readonly class HeroWaterCollisionHandler extends CollisionHandler
{
    public function match(MapObjects $former, MapObjects $latter): bool
    {
        return $former instanceof Treasure && $latter instanceof Obstacle ||
            $former instanceof Obstacle && $latter instanceof Treasure;
    }

    public function handleCollision(MapObjects $former, MapObjects $latter): void
    {
        echo "{$former->getSymbol()} and {$latter->getSymbol()} collision, water removed and hero healed\n";

        /** @var Treasure $hero  */
        [$hero, $water] = $this->assignMapObjects($former, $latter, Treasure::class);

        $hero->heal();
        $water->remove();

        // If the hero is the former, keep moving the hero
        if ($hero === $former) {
            $from = $former->getCoordinate();
            $to = $latter->getCoordinate();
            $from->swap($to);
        }
    }
}
