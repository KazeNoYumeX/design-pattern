<?php

namespace C2MB\Cards\CardPatterns;

use C2MB\Cards\Card;

/**
 * @property Card[] $cards
 */
abstract class CardPattern
{
    public function __construct(
        public array $cards = []
    ) {}

    public function getCards(): array
    {
        return $this->cards;
    }

    abstract public function match(array $cards): bool;

    public function maxCard(): Card
    {
        return $this->cards[0];
    }

    protected function sortCardsByCompare(array $cards): array
    {
        $condition = fn (Card $former, Card $latter) => $former->compare($latter) ? 1 : -1;
        usort($cards, $condition);

        return $cards;
    }
}
