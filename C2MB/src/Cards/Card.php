<?php

namespace C2MB\Cards;

use C2MB\Enums\RankEnum;
use C2MB\Enums\SuitEnum;

readonly class Card
{
    public function __construct(
        private RankEnum $rank,
        private SuitEnum $suit
    ) {}

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

    public function compare(Card $card): bool
    {
        $rank = $this->getRank();
        if ($rank->compare($otherRank = $card->getRank())) {
            return true;
        }

        $suit = $this->getSuit();

        return $rank === $otherRank && $suit->compare($card->getSuit());
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
