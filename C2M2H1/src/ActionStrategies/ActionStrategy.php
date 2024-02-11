<?php

namespace C2M2H1\ActionStrategies;

interface ActionStrategy
{
    public function takeAction(array $actions): int;

    public function generateName(): string;
}
