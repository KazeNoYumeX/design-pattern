<?php

namespace C3M3H1\States;

class Accelerated extends State
{
    public function __construct()
    {
        $this->name = '加速';
        $this->setDuration(3);
    }

    public function onTakeAction(): void
    {
        $this->role->takeAction();
    }

    public function onAttack(int $damage = 0): int
    {
        $this->exitState();

        return $damage;
    }
}
