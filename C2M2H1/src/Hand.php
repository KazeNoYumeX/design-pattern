<?php

namespace C2M2H1;

class Hand
{
    public array $cards = [];

    public function __construct($cards = [])
    {
        $this->cards = $cards;
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}
