<?php

namespace C3M3H1\Cards;

use C3M3H1\Enums\TreasuresEnum;
use C3M3H1\Enums\SuitEnum;

readonly class Card
{
    private TreasuresEnum $rank;

    private SuitEnum $suit;

    public function __construct(TreasuresEnum $rank, SuitEnum $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    public static function createCards(int $num = 52): array
    {
        $cards = [];
        foreach (SuitEnum::cases() as $suit) {
            foreach (TreasuresEnum::cases() as $rank) {
                if (count($cards) >= $num) {
                    break 2;
                }

                $cards[] = new self($rank, $suit);
            }
        }

        return $cards;
    }

    public function compare(Card $card): bool
    {
        if ($card->getRank()->value > $this->getRank()->value) {
            return true;
        } elseif ($card->getRank()->value == $this->getRank()->value) {
            if ($card->getSuit()->value > $this->getSuit()->value) {
                return true;
            }
        }

        return false;
    }

    public function getRank(): TreasuresEnum
    {
        return $this->rank;
    }

    public function getSuit(): SuitEnum
    {
        return $this->suit;
    }
}
