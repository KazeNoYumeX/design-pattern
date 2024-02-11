<?php

namespace C2M2H1\Cards;

use C2M2H1\Enums\ColorEnum;

class UnoCard extends Card
{
    private readonly int $number;

    private readonly ColorEnum $color;

    public function __construct(ColorEnum $color, int $number)
    {
        $this->color = $color;
        $this->number = max(0, min(9, $number));
    }

    public static function createCards(int $num = 40): array
    {
        $cards = [];
        foreach (ColorEnum::cases() as $color) {
            for ($i = 0; $i < 10; $i++) {
                if (count($cards) >= $num) {
                    break 2;
                }
                $cards[] = new self($color, $i);
            }
        }

        return $cards;
    }

    public function compare(UnoCard $card): bool
    {
        if ($this->getColor() === $card->getColor()) {
            return true;
        } elseif ($this->getNumber() === $card->getNumber()) {
            return true;
        }

        return false;
    }

    public function getColor(): ColorEnum
    {
        return $this->color;
    }

    public function getNumber(): int
    {
        return $this->number;
    }
}
