<?php

namespace src\Matches;

use App\Individual;
use src\Interfaces\Strategy;

class ReverseMatch extends SystemMatch
{
    public function findBestMatch(Individual $individual, array $individuals, Strategy $strategy): Individual
    {
        $sortedIndividuals = $strategy->sortConditions($individuals);
        $sortedIndividuals = $this->reverse($sortedIndividuals);
        return $sortedIndividuals[0];
    }
}
