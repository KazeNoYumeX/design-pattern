<?php

namespace App\Enums;

enum SuitEnum: int
{
    case CLUB = 0;
    case DIAMOND = 1;
    case HEART = 2;
    case SPADE = 3;

    public function toCardString(): string
    {
        return match ($this) {
            self::CLUB => '♣',
            self::DIAMOND => '♦',
            self::HEART => '♥',
            self::SPADE => '♠',
        };
    }
}
