<?php

namespace C2M3H1\CollisionHandlers;

use C2M3H1\Sprites\HeroSprite;
use C2M3H1\Sprites\Sprite;
use C2M3H1\Sprites\WaterSprite;

readonly class HeroWaterCollisionHandler extends CollisionHandler
{
    public function match(Sprite $former, Sprite $latter): bool
    {
        return $former instanceof HeroSprite && $latter instanceof WaterSprite ||
            $former instanceof WaterSprite && $latter instanceof HeroSprite;
    }

    public function handleCollision(Sprite $former, Sprite $latter): void
    {
        echo "{$former->getSymbol()} and {$latter->getSymbol()} collision, water removed and hero healed\n";

        $hero = $former;
        $water = $latter;

        if (! $hero instanceof HeroSprite) {
            $hero = $latter;
            $water = $former;
        }

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
