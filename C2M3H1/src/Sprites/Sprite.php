<?php

namespace C2M3H1\Sprites;

use C2M3H1\Coordinate;

abstract class Sprite
{
    protected string $symbol;

    public function __construct(
        protected Coordinate $coordinate
    ) {
    }

    public function showSymbol(): string
    {
        return $this->getSymbol();
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function remove(): void
    {
        $this->coordinate->setObject(null);
    }
}
