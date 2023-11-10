<?php

namespace src\Strategies;

use src\Interfaces\Strategy;

class DistanceBasedStrategy implements Strategy
{
    public function sortConditions(array $conditions): array
    {
        return $conditions;
    }
}
