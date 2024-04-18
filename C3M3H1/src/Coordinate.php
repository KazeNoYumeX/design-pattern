<?php

namespace C3M3H1;

use C3M3H1\MapObjects\MapObjects;

class Coordinate
{
    public ?MapObjects $object;

    public function __construct(
        private readonly int $x,
        private readonly int $y,
    ) {
        $this->setObject(null);
    }

    public function showSymbol(): void
    {
        $x = $this->getX();
        if ($x % 5 === 0 && $x !== 0) {
            echo ' ';
        }

        echo $this->object?->showSymbol() ?? '-';
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function swap(Coordinate $to): void
    {
        $fromObject = $this->getObject();
        $toObject = $to->getObject();

        $this->setObject($toObject);
        $to->setObject($fromObject);
    }

    public function getObject(): ?MapObjects
    {
        return $this->object;
    }

    public function setObject(?MapObjects $object): void
    {
        $this->object = $object;
    }
}
