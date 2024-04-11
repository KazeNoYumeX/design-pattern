<?php

namespace C3M3H1\States;

class Invincible extends State
{
    public function __construct()
    {
        $this->name = '無敵';
        $this->setDuration(2);
    }

    public function onAttack(int $damage = 0): int
    {
        return 0;
    }
}
