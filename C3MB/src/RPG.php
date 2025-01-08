<?php

namespace C3MB;

use C3MB\Units\Hero;

class RPG
{
    protected ?Battle $battle = null;

    protected ?Hero $hero = null;

    public function startBattle(Battle $battle, array $options): void
    {
        // Set the battle to the game
        $this->setBattle($battle);
        $battle->setGame($this);

        $battle->start($options);
    }

    private function setBattle(Battle $battle): void
    {
        $this->battle = $battle;
    }

    public function end(): void
    {
        $hero = $this->getHero();
        if ($hero->dead()) {
            echo '你失敗了！'.PHP_EOL;

            return;
        }

        $troop = $this->hero->getTroop();
        echo '你'.($troop->annihilated() ? '失敗' : '獲勝').'了！'.PHP_EOL;
    }

    public function getHero(): ?Hero
    {
        return $this->hero;
    }

    public function setHero(Hero $hero): void
    {
        $this->hero = $hero;
    }
}
