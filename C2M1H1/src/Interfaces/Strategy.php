<?php

namespace C2M1H1\Interfaces;

use C2M1H1\Individual;

interface Strategy
{
    public function sortConditions(Individual $individual, array $conditions): array;
}
