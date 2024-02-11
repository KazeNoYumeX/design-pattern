<?php

namespace C2M3H1\CollisionHandlers;

use C2M3H1\Sprites\FireSprite;
use C2M3H1\Sprites\HeroSprite;
use C2M3H1\Sprites\Sprite;

readonly class HeroFireCollisionHandler extends CollisionHandler
{
    public function match(Sprite $former, Sprite $latter): bool
    {
        return $former instanceof HeroSprite && $latter instanceof FireSprite ||
            $former instanceof FireSprite && $latter instanceof HeroSprite;
    }

    public function handleCollision(Sprite $former, Sprite $latter): void
    {
        echo "{$former->getSymbol()} and {$latter->getSymbol()} collision, fire removed and hero damaged\n";

        $hero = $former;
        $fire = $latter;

        if (! $hero instanceof HeroSprite) {
            $hero = $latter;
            $fire = $former;
        }

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
