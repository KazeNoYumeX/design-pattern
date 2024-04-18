<?php

namespace C3M3H1\CollisionHandlers;

use C3M3H1\MapObjects\FireMapObjects;
use C3M3H1\MapObjects\Treasure;
use C3M3H1\MapObjects\MapObjects;

readonly class HeroFireCollisionHandler extends CollisionHandler
{
    public function match(MapObjects $former, MapObjects $latter): bool
    {
        return $former instanceof Treasure && $latter instanceof FireMapObjects ||
            $former instanceof FireMapObjects && $latter instanceof Treasure;
    }

    public function handleCollision(MapObjects $former, MapObjects $latter): void
    {
        echo "{$former->getSymbol()} and {$latter->getSymbol()} collision, fire removed and hero damaged\n";

        /** @var Treasure $hero  */
        [$hero, $fire] = $this->assignMapObjects($former, $latter, Treasure::class);

        $fire->remove();
        $alive = $hero->damage();

        // If the hero is the former and still alive, keep moving the hero
        if ($alive && $hero === $former) {
            $from = $former->getCoordinate();
            $to = $latter->getCoordinate();
            $from->swap($to);
        }
    }
}
