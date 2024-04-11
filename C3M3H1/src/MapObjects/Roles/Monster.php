<?php

namespace C3M3H1\MapObjects\Roles;

use C3M3H1\AttackTypes\Attack;

class Monster extends Role
{
    public string $name = 'Monster';

    protected int $maxHp = 1;

    protected int $attack = 50;

    protected int $attackRange = 1;

    public function __construct()
    {
        parent::__construct();

        $this->setSymbol('M')
            ->setHp($this->maxHp)
            ->setAttackType(new Attack($this));
    }

    public function getAttackRange(): int
    {
        return $this->attackRange;
    }
}
