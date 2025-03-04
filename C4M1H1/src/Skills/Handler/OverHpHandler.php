<?php

namespace C3MB\Skills\Handler;

use C3MB\Units\Unit;

readonly class OverHpHandler extends EffectHandler
{
    public function match(Unit $unit): bool
    {
        return $unit->getHp() >= 500;
    }

    public function effect(): callable
    {
        return fn (Unit $unit) => $unit->damage(300);
    }
}
