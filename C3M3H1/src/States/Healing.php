<?php

namespace C3M3H1\States;

class Healing extends State
{
    public function __construct()
    {
        $this->name = '恢復';
        $this->setDuration(5);
    }

    public function onTakeAction(): void
    {
        $this->role->heal(30);
    }

    public function onHeal(int $heal = 0): void
    {
        $role = $this->role;
        $healed = $role->getHp() + $heal;

        if ($healed >= $role->getMaxHp()) {
            $this->exitState();
        }
    }
}
