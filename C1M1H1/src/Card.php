<?php

namespace C1M1H1;

use C1M1H1\Enums\RankEnum;
use C1M1H1\Enums\SuitEnum;

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
