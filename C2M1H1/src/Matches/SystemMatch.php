<?php

namespace C2M1H1\Matches;

use C2M1H1\Individual;
use C2M1H1\Interfaces\Strategy;

abstract class SystemMatch
{
    abstract public function findBestMatch(Individual $individual, array $individuals, Strategy $strategy): Individual;

    public function reverse(array $individuals): array
    {
        return array_reverse($individuals);
    }
}
