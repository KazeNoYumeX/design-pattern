<?php

namespace C2MB\Cards;

use C2MB\Enums\RankEnum;
use C2MB\Enums\SuitEnum;

class PokerCard extends Card
{
    private readonly RankEnum $rank;

    private readonly SuitEnum $suit;

    public function __construct(RankEnum $rank, SuitEnum $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
    }

    public static function createCards(int $num = 52): array
    {
        $cards = [];
        foreach (SuitEnum::cases() as $suit) {
            foreach (RankEnum::cases() as $rank) {
                if (count($cards) >= $num) {
                    break 2;
                }

                $cards[] = new self($rank, $suit);
            }
        }

        return $cards;
    }

    public function compare(PokerCard $card): bool
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

    public function getRank(): RankEnum
    {
        return $this->rank;
    }

    public function getSuit(): SuitEnum
    {
        return $this->suit;
    }
}
