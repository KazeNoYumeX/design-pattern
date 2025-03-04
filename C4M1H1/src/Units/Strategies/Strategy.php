<?php

namespace C3MB\Units\Strategies;

interface Strategy
{
    public function chooseAction(array $options): int;

    public function chooseTarget(array $options, int $num = 1): array;
}
