<?php

namespace MatchmakingSystem;

use MatchmakingSystem\Interfaces\Strategy;
use MatchmakingSystem\Matches\SystemMatch;

class MatchmakingSystem
{
    private readonly array $individuals;

    public function __construct(array $individuals)
    {
        $this->individuals = $individuals;
    }

    public function match(Individual $individual, SystemMatch $systemMatch, Strategy $strategy): Individual
    {
        $individuals = $this->getIndividuals();

        return $systemMatch->findBestMatch($individual, $individuals, $strategy);
    }

    public function getIndividuals(): array
    {
        return $this->individuals;
    }
}
