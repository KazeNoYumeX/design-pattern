<?php

namespace C3M3H1\MapObjects\Roles;

use C3M3H1\AttackTypes\DictionAttack;
use C3M3H1\Enums\Direction;

class Character extends Role
{
    public Direction $direction;

    public string $name = 'Character';

    protected int $maxHp = 300;

    protected int $attack = 50;

    public function __construct()
    {
        parent::__construct();

        $direction = Direction::pickRandom();
        $attackType = new DictionAttack($this);

        $this->setDirection($direction)
            ->setHp($this->maxHp)
            ->setAttackType($attackType);
    }

    public function getDirection(): Direction
    {
        return $this->direction;
    }

    public function setDirection(?Direction $direction): static
    {
        if ($direction instanceof Direction) {
            $this->direction = $direction;
            $this->setSymbol($direction->toSymbol());
        }

        return $this;
    }
}
