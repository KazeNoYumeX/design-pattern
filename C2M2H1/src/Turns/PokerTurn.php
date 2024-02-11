<?php

namespace C2M2H1\Turns;

use C2M2H1\Cards\PokerCard;
use C2M2H1\Players\PokerPlayer;

class PokerTurn extends Turn
{
    public function init(): void
    {
        $game = $this->getGame();

        $deck = $game->deck;
        echo "開始洗牌\n";
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

        // Plus the turn number and show the turn number
        $turn = $this->addTurn();
        echo "第{$turn}回合開始\n";

        // Each player plays to choose an action
        foreach ($players as $player) {
            /** @var PokerPlayer $player */
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
            /** @var PokerCard $card */
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

        /** @var PokerPlayer $winner */
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
}
