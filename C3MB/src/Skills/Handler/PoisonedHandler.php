<?php

namespace C3MB\Skills\Handler;

use C3MB\States\Poisoned;
use C3MB\Units\Unit;

readonly class PoisonedHandler extends EffectHandler
{
    public function match(Unit $unit): bool
    {
        $state = $unit->getState();

        return $state instanceof Poisoned;
    }

    public function effect(): callable
    {
        return function (Unit $unit) {
            for ($i = 0; $i < 3; $i++) {
                $unit->damage(80);
            }
        };
    }
}
