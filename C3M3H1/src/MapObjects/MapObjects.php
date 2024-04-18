<?php

namespace C3M3H1\MapObjects;

use C3M3H1\Coordinate;
use C3M3H1\ObjectBehavior\Generable;

abstract class MapObjects implements Generable
{
    protected string $symbol;

    public function __construct(
        protected array $options,
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
