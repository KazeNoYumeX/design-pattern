<?php

namespace CardGameFramework\ActionStrategies;

interface ActionStrategy
{
    public function takeAction(array $actions): int;

    public function generateName(): string;
}
