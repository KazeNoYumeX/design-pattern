<?php

namespace C2MB;

use C2MB\Cards\Card;
use C2MB\Cards\CardPatterns\CardPattern;
use C2MB\Enums\RankEnum;
use C2MB\Enums\SuitEnum;
use C2MB\Players\Player;

class Field
{
    public function __construct(
        private ?CardPattern $topPlay = null,
        public ?Player $topPlayer = null,
    ) {}

    public function getTopPlay(): ?CardPattern
    {
        return $this->topPlay;
    }

    public function setTopPlay(CardPattern $topPlay): void
    {
        $this->topPlay = $topPlay;
    }

    public function getTopPlayer(): ?Player
    {
        return $this->topPlayer;
    }

    public function setTopPlayer(Player $player): void
    {
        $this->topPlayer = $player;
    }

    public function playable(Player $player): bool
    {
        $topPlayer = $this->getTopPlayer();

        // If no top player, it means the first round and need play the 3 of club
        if ($topPlayer === null) {
            $hand = $player->getHand();
            $firstCard = new Card(RankEnum::THREE, SuitEnum::CLUB);
            if (in_array($firstCard, $hand)) {
                return true;
            }
        }

        return $topPlayer === $player;
    }

    public function validateTopPlay(CardPattern $cards): bool
    {
        $topPlayer = $this->getTopPlayer();
        if ($topPlayer === null) {
            return true;
        }
    }
}
