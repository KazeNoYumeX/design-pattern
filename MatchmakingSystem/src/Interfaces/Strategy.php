<?php

namespace Showdown\Interfaces;

use Showdown\Individual;

interface Strategy
{
    public function sortConditions(Individual $individual, array $conditions): array;
}
