<?php

namespace C3M3H1\Enums;

use C3M3H1\MapObjects\Treasure;

enum TreasuresEnum: string
{

    case SUPER_STAR = '無敵星星';
    case POISON = '毒藥';
//    case ACCELERATING_POTION = 5;
//    case SIX = 6;
//    case SEVEN = 7;
//    case EIGHT = 8;
//    case NINE = 9;
//    case TEN = 10;
//    case JACK = 11;
//    case QUEEN = 12;
//    case KING = 13;
//    case ACE = 14;
//    case BIG_TWO = 15;

    public function generateTreasure()
    {
        $treasures = Treasure::getTreasures();
        $totalProbability = array_sum(array_column($treasures, 'probability'));

        $random = mt_rand() / mt_getrandmax() * $totalProbability;

        foreach ($treasures as $treasure) {
            $totalProbability -= $treasure['probability'];
            if ($random >= $totalProbability) {
                return $treasure;
            }
        }

        return end($treasures);
    }

    public function toRate(): int
    {
        return match ($this) {
            self::ACE => 0.1,
            self::BIG_TWO => 15,
            self::THREE => 3,
            self::FOUR => 4,
            self::FIVE => 5,
            self::SIX => 6,
            self::SEVEN => 7,
            self::EIGHT => 8,
            self::NINE => 9,
            self::TEN => 10,
            self::JACK => 11,
            self::QUEEN => 12,
            self::KING => 13,
        };
    }

}
