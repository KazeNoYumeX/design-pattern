<?php

namespace MatchmakingSystem\Interfaces;

use MatchmakingSystem\Individual;

interface Strategy
{
    public function sortConditions(Individual $individual, array $conditions): array;
}
