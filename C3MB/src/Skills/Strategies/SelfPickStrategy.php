<?php

namespace C3MB\Skills\Strategies;

readonly class SelfPickStrategy extends PickStrategy
{
    public function pickTarget(array $troops): array
    {
        $action = $this->action;

        $executor = $action->getExecutor();

        return [$executor];
    }
}
