<?php

namespace C3MB\Skills\Handler;

use C3MB\States\Cheerup;
use C3MB\States\Normal;
use C3MB\Units\Unit;

readonly class CheerupStatusHandler extends EffectHandler
{
    public function match(Unit $unit): bool
    {
        $state = $unit->getState();

        return $state instanceof Cheerup;
    }

    public function effect(): callable
    {
        return function (Unit $unit) {
            $unit->damage(100);
            $unit->setState(new Normal);
        };
    }
}
