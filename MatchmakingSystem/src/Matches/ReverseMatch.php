<?php

namespace App\Matches;

use App\Individual;
use App\Interfaces\Strategy;

class ReverseMatch extends SystemMatch
{
    private readonly string $name;

    public function __construct()
    {
        $this->name = 'Reverse Match';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function findBestMatch(Individual $individual, array $individuals, Strategy $strategy): Individual
    {
        // Filter out the individual itself
        $individuals = array_filter($individuals, fn ($i) => $i->getId() !== $individual->getId());

        $sortedIndividuals = $strategy->sortConditions($individual, $individuals);
        $sortedIndividuals = $this->reverse($sortedIndividuals);

        return $sortedIndividuals[0];
    }
}
