<?php

namespace MatchmakingSystem;

class Coordinate
{
    private readonly float $x;

    private readonly float $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getPosition(): array
    {
        return [$this->x, $this->y];
    }

    public function getPositionToString(): string
    {
        return sprintf('(%s, %s)', $this->x, $this->y);
    }
}
