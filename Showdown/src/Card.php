<?php

namespace App;

use App\Enums\RankEnum;
use App\Enums\SuitEnum;

class Card
{
    private RankEnum $rank;

    private SuitEnum $suit;

    public function __construct(RankEnum $rank, SuitEnum $suit)
    {
        $this->rank = $rank;
        $this->suit = $suit;
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
