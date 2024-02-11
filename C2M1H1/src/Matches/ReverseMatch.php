<?php

namespace C2M1H1\Matches;

use C2M1H1\Individual;
use C2M1H1\Interfaces\Strategy;

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
