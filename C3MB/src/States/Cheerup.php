<?php

namespace C3MB\States;

class Cheerup extends State
{
    public function __construct(
        protected int $duration = 3,
    ) {
        parent::__construct('受到鼓舞', $duration);
    }

    public function onAttack(int $damage = 0): int
    {
        return $damage ? $damage + 50 : $damage;
    }
}
