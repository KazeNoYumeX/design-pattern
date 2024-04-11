<?php

namespace C3M3H1\States;

use C3M3H1\MapObjects\Roles\Role;

abstract class State
{
    protected ?Role $role = null;

    public function __construct(
        public string $name,
        private int $duration = 1,
    ) {}

    public function onTakeAction() {}

    public function onAttack(int $damage = 0): int
    {
        $this->role?->enterState(new Invincible);

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
        $this->role?->enterState(new Normal);
    }
}
