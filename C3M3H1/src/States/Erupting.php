<?php

namespace C3M3H1\States;

use C3M3H1\AttackTypes\Attack;
use C3M3H1\AttackTypes\DictionAttack;
use C3M3H1\AttackTypes\FullRangeAttack;
use C3M3H1\MapObjects\Roles\Character;
use C3M3H1\MapObjects\Roles\Role;

class Erupting extends State
{
    public function __construct()
    {
        $this->name = '爆發';
        $this->setDuration(3);
    }

    public function enterState(Role $role): static
    {
        parent::exitState();

        // Set the full range attack type
        $attackType = new FullRangeAttack($role);
        $this->role->setAttackType($attackType);
        $this->role->setAttack(50);

        return $this;
    }

    public function exitState(): void
    {
        $role = $this->role;
        $attackType = $role instanceof Character ? new DictionAttack($role) : new Attack($role);
        $this->role->setAttackType($attackType);
        $this->role->setAttack(50);

        $this->role->enterState(new Teleport);
    }
}
