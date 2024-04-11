<?php

namespace C3M3H1\States;

class Poisoned extends State
{
    public function __construct()
    {
        $this->name = '中毒';
        $this->setDuration(3);
    }

    public function onTakeAction(): void
    {
        $this->role->damage(15);
    }
}
