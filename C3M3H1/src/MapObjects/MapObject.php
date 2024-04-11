<?php

namespace C3M3H1\MapObjects;

use C3M3H1\Coordinate;
use C3M3H1\MapOption;

abstract class MapObject
{
    protected ?Coordinate $coordinate;

    protected MapOption $option;

    protected string $symbol;

    public function showSymbol(): string
    {
        return $this->getSymbol();
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): static
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function setCoordinate(Coordinate $coordinate): void
    {
        $this->coordinate = $coordinate;
    }

    public function dead(): void
    {
        $this->remove();
    }

    public function remove(): void
    {
        $this->coordinate?->removeObject($this);
    }

    public function takeAction(): void
    {
        $option = $this->getOption();

        if ($option->movable()) {
            $this->move();
        }
    }

    public function getOption(): MapOption
    {
        return $this->option;
    }

    public function setOption(MapOption $option): void
    {
        $this->option = $option;
    }

    public function move(): void {}

    public function touch(MapObject $object): void {}

    public function endAction() {}
}
