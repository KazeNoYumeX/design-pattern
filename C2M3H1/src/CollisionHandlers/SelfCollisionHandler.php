<?php

namespace C2M3H1\CollisionHandlers;

use C2M3H1\Sprites\Sprite;

readonly class SelfCollisionHandler extends CollisionHandler
{
    public function match(Sprite $former, Sprite $latter): bool
    {
        return $former instanceof $latter;
    }

    public function handleCollision(Sprite $former, Sprite $latter): void
    {
        echo "{$former->getSymbol()} to {$latter->getSymbol()} same type collision, move failed\n";
    }
}
