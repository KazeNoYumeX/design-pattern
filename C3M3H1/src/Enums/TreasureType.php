<?php

namespace C3M3H1\Enums;

use C3M3H1\States\Accelerated;
use C3M3H1\States\Healing;
use C3M3H1\States\Invincible;
use C3M3H1\States\Orderless;
use C3M3H1\States\Poisoned;
use C3M3H1\States\State;
use C3M3H1\States\Stockpile;
use C3M3H1\States\Teleport;

enum TreasureType: int
{
    case SUPER_STAR = 1;
    case POISON = 2;
    case ACCELERATING_POTION = 3;
    case HEALING_POTION = 4;
    case DEVIL_FRUIT = 5;
    case KING_ROCK = 6;
    case DOKODEMO_DOOR = 7;

    public static function generateTreasureType(): TreasureType
    {
        $treasures = TreasureType::cases();

        $total = array_sum(array_map(fn ($treasure) => $treasure->toRate(), $treasures));
        $random = mt_rand() / mt_getrandmax() * $total;

        foreach ($treasures as $treasure) {
            $random -= $treasure->toRate();
            if ($random <= 0) {
                return $treasure;
            }
        }

        return end($treasures);
    }

    public function toRate(): float
    {
        return match ($this) {
            self::SUPER_STAR, self::DEVIL_FRUIT, self::KING_ROCK, self::DOKODEMO_DOOR => 0.1,
            self::POISON => 0.25,
            self::ACCELERATING_POTION => 0.2,
            self::HEALING_POTION => 0.15,
        };
    }

    public function toTreasureName(): string
    {
        return match ($this) {
            self::SUPER_STAR => '無敵星星',
            self::POISON => '毒藥',
            self::ACCELERATING_POTION => '加速藥水',
            self::HEALING_POTION => '補血罐',
            self::DEVIL_FRUIT => '惡魔果實',
            self::KING_ROCK => '王者之印',
            self::DOKODEMO_DOOR => '任意門',
        };
    }

    public function toState(): State
    {
        return match ($this) {
            self::SUPER_STAR => new Invincible,
            self::POISON => new Poisoned,
            self::ACCELERATING_POTION => new Accelerated,
            self::HEALING_POTION => new Healing,
            self::DEVIL_FRUIT => new Orderless,
            self::KING_ROCK => new Stockpile,
            self::DOKODEMO_DOOR => new Teleport,
        };
    }
}
