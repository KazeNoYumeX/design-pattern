<?php

namespace C2MB\ActionStrategies;

interface ActionStrategy
{
    public function takeAction(array $actions): int;

    public function generateName(): string;
}
