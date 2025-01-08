<?php

namespace C3MB\Skills\Strategies;

readonly class NonePickStrategy extends PickStrategy
{
    public function pickTarget(array $troops): array
    {
        return [];
    }
}
