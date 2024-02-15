<?php

namespace C2MB;

use C2MB\Players\Player;

class Field
{
    public function __construct(
        private array $cards = [],
        public ?Player $topPlayer = null,
    ) {}

    public function getCards(): array
    {
        return $this->cards;
    }

    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }

    public function getTopPlayer(): Player
    {
        return $this->topPlayer;
    }

    public function setTopPlayer(Player $player): void
    {
        $this->topPlayer = $player;
    }
}
