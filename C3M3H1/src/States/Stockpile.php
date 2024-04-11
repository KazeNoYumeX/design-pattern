<?php

namespace C3M3H1\States;

class Stockpile extends State
{
    public function __construct()
    {
        $this->name = '蓄力';
        $this->setDuration(2);
    }

    public function onAttack(int $damage = 0): int
    {
        // Set the state to Normal
        parent::exitState();

        return $damage;
    }

    public function exitState(): void
    {
        $this->role->enterState(new Erupting);
    }
}
