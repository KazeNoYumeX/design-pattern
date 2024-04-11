<?php

namespace C3M3H1\States;

class Healing extends State
{
    public function __construct()
    {
        parent::__construct('恢復', 5);
    }

    public function onTakeAction(): void
    {
        $this->role?->heal(30);
    }

    public function onHeal(int $heal = 0): void
    {
        $role = $this->role;
        if (! $role) {
            return;
        }

        $healed = $role->getHp() + $heal;

        if ($healed >= $role->getMaxHp()) {
            $this->exitState();
        }
    }
}
