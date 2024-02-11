<?php

namespace C2M3H1\Sprites;

use C2M3H1\Coordinate;

class HeroSprite extends Sprite
{
    private int $hp = 30;

    public function __construct(
        protected Coordinate $coordinate
    ) {
        parent::__construct($coordinate);
        $this->setSymbol('H');
    }

    public function dead(): void
    {
        echo "Hero dead\n";
        $this->remove();
    }

    public function damage(int $damage = 10): bool
    {
        $hp = $this->getHp();
        $this->setHp($hp - $damage);
        echo "Hero get damage, damage: {$damage}, left hp: {$this->getHp()}\n";

        if ($this->hp <= 0) {
            $this->dead();
        }

        return $this->hp >= 0;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function setHp(int $hp): void
    {
        $this->hp = $hp;
    }

    public function heal(int $heal = 10): void
    {
        $hp = $this->getHp();
        $this->setHp($hp + $heal);

        echo "Hero get heal, heal: {$heal}, left hp: {$this->getHp()}\n";
    }
}
