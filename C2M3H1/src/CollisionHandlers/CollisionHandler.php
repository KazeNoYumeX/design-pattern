<?php

namespace C2M3H1\CollisionHandlers;

use C2M3H1\Sprites\Sprite;

abstract readonly class CollisionHandler
{
    public function __construct(
        protected ?CollisionHandler $next = null
    ) {
    }

    public function handle(Sprite $former, Sprite $latter): void
    {
        if ($this->match($former, $latter)) {
            echo 'Handling collision : ';
            $this->handleCollision($former, $latter);
        } else {
            $this->next?->handle($former, $latter);
        }
    }

    protected function assignSprites(Sprite $former, Sprite $latter, string $spriteClass): array
    {
        $firstSprite = $former;
        $secondSprite = $latter;

        if (! $firstSprite instanceof $spriteClass) {
            $firstSprite = $latter;
            $secondSprite = $former;
        }

        return [$firstSprite, $secondSprite];
    }

    abstract public function match(Sprite $former, Sprite $latter): bool;

    abstract public function handleCollision(Sprite $former, Sprite $latter): void;
}
