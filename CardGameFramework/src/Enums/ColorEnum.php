<?php

namespace CardGameFramework\Enums;

enum ColorEnum: int
{
    case BLUE = 0;
    case RED = 1;
    case YELLOW = 2;
    case GREEN = 3;

    public function toCardString(): string
    {
        return match ($this) {
            self::BLUE => 'Blue',
            self::RED => 'Red',
            self::YELLOW => 'Yellow',
            self::GREEN => 'Green',
        };
    }
}
