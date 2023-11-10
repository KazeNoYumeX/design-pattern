<?php

namespace src\Interfaces;

interface Strategy
{
    public function sortConditions(array $conditions): array;
}
