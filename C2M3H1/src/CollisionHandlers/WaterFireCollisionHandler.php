<?php

namespace C2M3H1\CollisionHandlers;

use C2M3H1\Sprites\FireSprite;
use C2M3H1\Sprites\Sprite;
use C2M3H1\Sprites\WaterSprite;

readonly class WaterFireCollisionHandler extends CollisionHandler
{
    public function match(Sprite $former, Sprite $latter): bool
    {
        return $former instanceof WaterSprite && $latter instanceof FireSprite ||
            $former instanceof FireSprite && $latter instanceof WaterSprite;
    }

    public function handleCollision(Sprite $former, Sprite $latter): void
    {
        echo "{$former->getSymbol()} and {$latter->getSymbol()} collision, both removed\n";
        $former->remove();
        $latter->remove();
    }
}
