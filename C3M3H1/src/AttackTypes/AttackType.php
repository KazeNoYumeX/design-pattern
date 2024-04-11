<?php

namespace C3M3H1\AttackTypes;

use C3M3H1\MapObjects\MapObject;
use C3M3H1\MapObjects\Roles\Role;

abstract class AttackType
{
    public function __construct(protected readonly Role $role) {}

    abstract public function attackable(): bool;

    abstract public function attack(): void;

    public function getRole(): MapObject
    {
        return $this->role;
    }
}
