<?php

namespace C3M3H1\States;

use C3M3H1\MapObjects\Roles\Character;
use C3M3H1\MapObjects\Roles\Role;

class State
{
    public string $name;

    protected ?Role $role = null;

    private int $duration;

    public function onTakeAction() {}

    public function onAttack(int $damage = 0): int
    {
        if ($this->role instanceof Character) {
            $this->role->enterState(new Invincible);
        }

        return $damage;
    }

    public function enterState(Role $role): static
    {
        $this->setRole($role);

        return $this;
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function onHeal() {}

    public function onMove(array $range): array
    {
        return $range;
    }

    public function onGetAction(array $actions): array
    {
        return $actions;
    }

    public function onEndAction(): void
    {
        $this->duration--;

        if ($this->duration <= 0) {
            $this->exitState();
        }
    }

    public function exitState(): void
    {
        if ($this->role instanceof Role) {
            $this->role->enterState(new Normal);
        }
    }

    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }
}
