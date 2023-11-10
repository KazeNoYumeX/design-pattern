<?php

namespace src\Strategies;

use src\Interfaces\Strategy;

class HabitBasedStrategy implements Strategy
{
    public function sortConditions(array $conditions): array
    {
        return $conditions;
    }
}
