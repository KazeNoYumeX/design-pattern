<?php

namespace C2MB\Cards\CardPatterns;

class Pair extends CardPattern
{
    public function match(array $cards): bool
    {
        $length = count($cards);
        if ($length !== 2) {
            return false;
        }

        return $cards[0]->getRank() === $cards[1]->getRank();
    }
}
