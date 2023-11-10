<?php

namespace App\Interfaces;

use App\Individual;

interface Strategy
{
    public function sortConditions(Individual $individual, array $conditions): array;
}
