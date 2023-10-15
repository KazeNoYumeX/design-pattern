<?php

namespace App;

use App\Enums\RankEnum;
use App\Enums\SuitEnum;

class Deck
{
    private array $cards = [];

    public function __construct()
    {
        foreach (SuitEnum::cases() as $suit) {
            foreach (RankEnum::cases() as $rank) {
                $this->cards[] = new Card($rank, $suit);
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function draw(): Card
    {
        return array_pop($this->cards);
    }
}
