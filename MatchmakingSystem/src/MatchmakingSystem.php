<?php

use App\Individual;
use src\Interfaces\Strategy;
use src\Matches\SystemMatch;

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

        public function match(Individual $individual,SystemMatch $systemMatch, Strategy $strategy): array
        {
            $individuals = $this->getIndividuals();
            $bestMatch = $systemMatch->findBestMatch($individual,$individuals,$strategy);
            return [$individual,$bestMatch];
        }

}
