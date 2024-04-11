<?php

namespace C3M3H1\States;

class Poisoned extends State
{
    public function __construct()
    {
        parent::__construct('中毒', 3);
    }

    public function onTakeAction(): void
    {
        $this->role?->damage(15);
    }
}
