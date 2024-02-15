<?php

namespace C2MB;

use C2MB\Cards\Card;
use C2MB\Players\Player;

class Round
{
    public function __construct(
        private readonly BigTwo $game
    ) {}

    private int $num = 0;

    public function init(): void
    {
        $game = $this->getGame();

        echo "開始洗牌\n";
        $deck = $game->getDeck();
        $deck->shuffle();

        echo "開始抽牌\n";
        // Distribute 13 cards to each player
        $players = $game->getPlayers();
        $deck->distributeCards($players, 13);
    }

    public function start(): void
    {
        $game = $this->getGame();
        $players = $game->getPlayers();

        // Plus the round number and show the turn number
        $round = $this->addRound();
        echo "第{$round}回合開始\n";

        // Each player plays to choose an action
        $passed = 0;
        $field = $game->getField();

        while (true) {
            foreach ($players as $player) {

            }
        }

        foreach ($players as $player) {
            /** @var Player $player */
            $player->takeTurn();
        }

        $this->getWinner();
        $this->end();
    }

    public function getWinner(): void
    {
        $game = $this->getGame();
        $players = $game->getPlayers();
        $maxIndex = 0;
        $max = null;

        foreach ($players as $index => $player) {
            /** @var Card $card */
            $card = $player->getShowedCard();

            if (empty($max)) {
                $max = $card;

                // Pass the first player
                continue;
            }

            // Compare card rank and suit
            if ($card->compare($max)) {
                $max = $card;
                $maxIndex = $index;
            }
        }

        // If no winner, break the turn
        if (empty($max)) {
            echo "本回合無人出牌\n";

            return;
        }

        $suit = $max->getSuit()->toCardString();
        $rank = $max->getRank()->toCardString();

        /** @var Player $winner */
        $winner = $players[$maxIndex];
        $winner->gainPoint();

        echo "本回合贏家為：{$winner->getName()}, ";
        echo "目前得分為：{$winner->getPoint()}, ";
        echo "最大的牌為：$suit $rank \n";
    }

    public function end(): void
    {
        $num = $this->getNum();
        echo "第{$num}回合結束\n";

        $game = $this->getGame();
        if ($game->endCondition()) {
            $winners = $game->getWinners();
            $game->end($winners);
        } else {
            $this->start();
        }
    }

    public function getGame(): BigTwo
    {
        return $this->game;
    }

    public function setGame(BigTwo $game): void
    {
        $this->game = $game;
    }

    public function addRound(): int
    {
        $turn = $this->getNum() + 1;
        $this->setNum($turn);

        return $turn;
    }

    public function getNum(): int
    {
        return $this->num;
    }

    public function setNum(int $num): void
    {
        $this->num = $num;
    }
}
