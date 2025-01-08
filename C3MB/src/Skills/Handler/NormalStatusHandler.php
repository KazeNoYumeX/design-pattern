<?php

namespace C3MB\Skills\Handler;

use C3MB\States\Normal;
use C3MB\Units\Unit;

readonly class NormalStatusHandler extends EffectHandler
{
    public function match(Unit $unit): bool
    {
        $state = $unit->getState();

        return $state instanceof Normal;
    }

    public function effect(): callable
    {
        return function (Unit $unit) {
            $unit->damage(100);
        };
    }
}
