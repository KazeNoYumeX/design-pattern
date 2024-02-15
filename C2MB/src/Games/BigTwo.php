<?php

namespace C2MB\Games;

use C2MB\ActionStrategies\AIActionStrategy;
use C2MB\ActionStrategies\HumanActionStrategy;
use C2MB\Players\PokerPlayer;

class BigTwo extends Game
{
    public function start(): void
    {
        if (! empty($this->turn)) {
            $turn = $this->getTurn();

            // Init the turn
            $turn->init();

            // Start the first round
            $turn->start();
        } else {
            // If the turn is not set, or do something in the future
            echo '請先設定回合';
        }
    }

    public function endCondition(): bool
    {
        return $this->turn->getNum() >= 13;
    }

    public function getWinners(): array
    {
        $players = $this->getPlayers();

        // Get the highest score
        $scores = array_map(fn ($player) => $player->getPoint(), $players);
        $max = max($scores);

        // Winner may be more than one
        return array_filter($players,
            fn ($player) => $player->getPoint() === $max);
    }
}
