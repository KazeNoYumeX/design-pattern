<?php

namespace C2M2H1\Games;

use C2M2H1\ActionStrategies\AIActionStrategy;
use C2M2H1\ActionStrategies\HumanActionStrategy;
use C2M2H1\Cards\UnoCard;
use C2M2H1\Field;
use C2M2H1\Players\UnoPlayer;

class Uno extends Game
{
    public function start(): void
    {
        // Init the field
        $this->field = new Field();

        $deck = $this->getDeck();
        echo "開始洗牌\n";
        $deck->shuffle();
        echo "開始抽牌\n";

        $players = $this->getPlayers();
        $deck->distributeCards($players, 5);

        // The first card of the field
        $field = $this->getField();
        $field->setCard($deck->draw());

        /** @var UnoCard $firstCard */
        $firstCard = $field->getCard();
        echo "第一張牌是 {$firstCard->getColor()->toCardString()} {$firstCard->getNumber()}\n";

        // Start the game process
        $this->process();
    }

    public function addPlayers(int $player, int $ai): void
    {
        for ($i = 0; $i < $player; $i++) {
            $player = new UnoPlayer($this, new HumanActionStrategy());
            echo '請輸入玩家'.$i + 1 .'名稱：';
            $player->nameHimself();
            $this->addPlayer($player);
        }

        for ($i = 0; $i < $ai; $i++) {
            $player = new UnoPlayer($this, new AIActionStrategy());
            $player->nameHimself();
            $this->addPlayer($player);
        }
    }

    public function endCondition(): bool
    {
        $players = $this->getPlayers();

        foreach ($players as $player) {
            $hand = $player->getHand();

            // Any player's hand is empty, game over
            if (count($hand) === 0) {
                return true;
            }
        }

        return false;
    }

    public function getWinners(): array
    {
        $players = $this->getPlayers();

        return array_filter($players, fn ($player) => count($player->getHand()) === 0);
    }

    public function process(): void
    {
        $players = $this->getPlayers();

        // Each player plays to choose an action
        foreach ($players as $player) {
            /** @var UnoPlayer $player */
            $player->takeTurn();

            // If the game end condition is met, end the game
            if ($this->endCondition()) {
                $winners = $this->getWinners();
                $this->end($winners);

                return;
            }
        }

        $this->process();
    }
}
