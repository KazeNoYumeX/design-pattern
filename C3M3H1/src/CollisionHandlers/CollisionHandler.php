<?php

namespace C3M3H1\CollisionHandlers;

use C3M3H1\MapObjects\MapObjects;

abstract readonly class CollisionHandler
{
    public function __construct(
        protected ?CollisionHandler $next = null
    ) {
    }

    public function handle(MapObjects $former, MapObjects $latter): void
    {
        if ($this->match($former, $latter)) {
            echo 'Handling collision : ';
            $this->handleCollision($former, $latter);
        } else {
            $this->next?->handle($former, $latter);
        }
    }

    protected function assignMapObjects(MapObjects $former, MapObjects $latter, string $spriteClass): array
    {
        $firstSprite = $former;
        $secondSprite = $latter;

        if (! $firstSprite instanceof $spriteClass) {
            $firstSprite = $latter;
            $secondSprite = $former;
        }

        return [$firstSprite, $secondSprite];
    }

    abstract public function match(MapObjects $former, MapObjects $latter): bool;

    abstract public function handleCollision(MapObjects $former, MapObjects $latter): void;
}
