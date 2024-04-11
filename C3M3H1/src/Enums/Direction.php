<?php

namespace C3M3H1\Enums;

enum Direction: int
{
    case NORTH = 0;
    case EAST = 90;
    case SOUTH = 180;
    case WEST = 270;

    public static function pickRandom(): Direction
    {
        $directions = self::cases();
        $pick = array_rand($directions);

        return $directions[$pick];
    }

    public function toSymbol(): string
    {
        return match ($this) {
            self::NORTH => '↑',
            self::EAST => '→',
            self::SOUTH => '↓',
            self::WEST => '←',
        };
    }

    public function toRange(): array
    {
        return match ($this) {
            self::NORTH => [0, 1],
            self::EAST => [1, 0],
            self::SOUTH => [0, -1],
            self::WEST => [-1, 0],
        };
    }
}
