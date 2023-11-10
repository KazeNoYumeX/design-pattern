<?php

namespace src\Matches;

use App\Individual;
use src\Interfaces\Strategy;

class StandardMatch extends SystemMatch
{
    public function findBestMatch(Individual $individual, array $individuals, Strategy $strategy): Individual
    {
        $sortedIndividuals = $strategy->sortConditions($individuals);
        return $sortedIndividuals[0];
    }
}
