<?php

namespace C3MB\Skills\Handler;

use C3MB\Units\Unit;

abstract readonly class EffectHandler
{
    public function __construct(
        protected ?EffectHandler $next = null
    ) {}

    public function handle(Unit $unit): void
    {
        if ($this->match($unit)) {
            $effect = $this->effect();
            $effect($unit);
        } else {
            $this->next->handle($unit);
        }
    }

    abstract public function match(Unit $unit): bool;

    abstract public function effect(): callable;
}
