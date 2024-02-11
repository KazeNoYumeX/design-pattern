<?php

namespace C2M2H1\Games;

use C2M2H1\ActionStrategies\AIActionStrategy;
use C2M2H1\ActionStrategies\HumanActionStrategy;
use C2M2H1\Players\PokerPlayer;

class Showdown extends Game
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

    public function addPlayers(int $player, int $ai): void
    {
        for ($i = 0; $i < $player; $i++) {
            echo '請輸入玩家'.$i + 1 .'名稱：';
            $player = new PokerPlayer($this, new HumanActionStrategy());
            $player->nameHimself();
            $this->addPlayer($player);
        }

        for ($i = 0; $i < $ai; $i++) {
            $player = new PokerPlayer($this, new AIActionStrategy());
            $player->nameHimself();
            $this->addPlayer($player);
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
