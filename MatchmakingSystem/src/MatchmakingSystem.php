<?php

namespace App;

use App\Interfaces\Strategy;
use App\Matches\SystemMatch;

class MatchmakingSystem
{
    private readonly array $individuals;

    public function __construct(array $individuals)
    {
        $this->individuals = $individuals;
    }

    public function getIndividuals(): array
    {
        return $this->individuals;
    }

    public function match(Individual $individual, SystemMatch $systemMatch, Strategy $strategy): Individual
    {
        $individuals = $this->getIndividuals();

        return $systemMatch->findBestMatch($individual, $individuals, $strategy);
    }
}
