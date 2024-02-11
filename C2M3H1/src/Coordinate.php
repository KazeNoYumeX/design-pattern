<?php

namespace C2M3H1;

use C2M3H1\Sprites\Sprite;

class Coordinate
{
    public ?Sprite $object;

    public function __construct(
        private readonly int $x,
    ) {
        $this->setObject(null);
    }

    public function showSymbol(): void
    {
        if ($this->getX() % 5 === 0) {
            echo ' ';
        }

        echo $this->object?->showSymbol() ?? '-';
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function swap(Coordinate $to): void
    {
        $fromObject = $this->getObject();
        $toObject = $to->getObject();

        $this->setObject($toObject);
        $to->setObject($fromObject);
    }

    public function getObject(): ?Sprite
    {
        return $this->object;
    }

    public function setObject(?Sprite $object): void
    {
        $this->object = $object;
    }
}
