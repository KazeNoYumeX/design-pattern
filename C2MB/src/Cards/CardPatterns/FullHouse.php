<?php

namespace C2MB\Cards\CardPatterns;

use C2MB\Cards\Card;

class FullHouse extends CardPattern
{
    public function match(array $cards): bool
    {
        $length = count($cards);
        if ($length !== 5) {
            return false;
        }

        // Count the number of cards with the same rank
        $values = array_count_values(array_map(fn ($card) => $card->getRank()->value, $cards));

        // Check if there are 2 cards with the same rank and 3 cards with the same rank
        return in_array(2, $values) && in_array(3, $values);
    }

    public function maxCard(): Card
    {
        $cards = $this->getCards();
        $values = array_count_values(array_map(fn ($card) => $card->getRank()->value, $cards));

        $threeOfAKindValue = array_search(3, $values);
        $cards = array_filter($cards, fn ($card) => $card->getRank()->value === $threeOfAKindValue);

        // Sort the cards by compare
        $cards = $this->sortCardsByCompare($cards);

        return $cards[0];
    }
}
