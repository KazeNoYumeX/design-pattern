<?php

namespace App\Matches;

use App\Individual;
use App\Interfaces\Strategy;

abstract class SystemMatch
{
    abstract public function findBestMatch(Individual $individual, array $individuals, Strategy $strategy): Individual;

    public function reverse(array $individuals): array
    {
        return array_reverse($individuals);
    }
}
