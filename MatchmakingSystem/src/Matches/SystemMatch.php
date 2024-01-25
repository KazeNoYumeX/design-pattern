<?php

namespace MatchmakingSystem\Matches;

use MatchmakingSystem\Individual;
use MatchmakingSystem\Interfaces\Strategy;

abstract class SystemMatch
{
    abstract public function findBestMatch(Individual $individual, array $individuals, Strategy $strategy): Individual;

    public function reverse(array $individuals): array
    {
        return array_reverse($individuals);
    }
}
