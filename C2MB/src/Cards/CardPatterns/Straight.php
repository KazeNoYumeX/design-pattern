<?php

namespace C2MB\Cards\CardPatterns;

use C2MB\Cards\Card;

class Straight extends CardPattern
{
    public function match(array $cards): bool
    {
        $length = count($cards);
        if ($length !== 5) {
            return false;
        }

        $values = array_map(fn ($card) => $card->getRank()->value, $cards);
        sort($values);

        // Special case for A-2-3-4-5 and 2-3-4-5-6
        if ($values === [3, 4, 5, 14, 15] || $values === [3, 4, 5, 6, 15]) {
            return true;
        }

        // Special case for J-Q-K-A-2
        if ($values === [11, 12, 13, 14, 15]) {
            return false;
        }

        // Check if the values are consecutive
        for ($i = 0; $i < $length - 1; $i++) {
            if ($values[$i + 1] !== $values[$i] + 1) {
                return false;
            }
        }

        return true;
    }

    public function maxCard(): Card
    {
        $cards = $this->getCards();
        $cards = $this->sortCardsByCompare($cards);

        // Special case for A-2-3-4-5
        $values = array_map(fn ($card) => $card->getRank()->value, $cards);
        if ($values === [15, 14, 5, 4, 3]) {
            return $cards[1];
        }

        return $cards[0];
    }
}
