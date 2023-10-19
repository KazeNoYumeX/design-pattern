<?php

namespace App;

use App\Players\AIPlayer;
use App\Players\HumanPlayer;

class Showdown
{
    private array $players;

    private int $round = 1;

    protected array $exchangeHands;

    public function __construct(
        private readonly Deck $deck
    ) {
        $this->exchangeHands = [];
    }

    public function startGame(int $numRealPlayers, int $numAIPlayers): void
    {
        // Total players
        $totalPlayers = $numRealPlayers + $numAIPlayers;

        $playerNum = 1;
        for ($i = 0; $i < $numRealPlayers; $i++) {
            $player = new HumanPlayer($this);
            echo "請輸入玩家{$playerNum}名稱：";
            $player->nameHimself();
            $this->addPlayer($player);
            $playerNum++;
        }

        if ($numAIPlayers != 0) {
            for ($i = 0; $i < $numAIPlayers; $i++) {
                $player = new AIPlayer($this);
                $player->nameHimself();
                $this->addPlayer($player);
            }
        }

        for ($i = 0; $i < $totalPlayers; $i++) {
            $num = $i + 1;
            echo "玩家{$num}名稱為：".$this->players[$i]->getName()."\n";
        }

        echo "遊戲開始, 玩家總人數為: $totalPlayers\n";

        echo "開始洗牌\n";
        $this->deck->shuffle();
        echo "開始抽牌\n";

        // Draw 13 cards for each player
        for ($i = 0; $i < 13; $i++) {
            foreach ($this->players as $player) {
                /** @var HumanPlayer|AIPlayer $player */
                $player->drawCard($this->deck);
            }
        }

        $this->startRound();
    }

    private function addPlayer(HumanPlayer|AIPlayer $player): void
    {
        $this->players[] = $player;
    }

    public function startRound(): void
    {
        echo "第{$this->round}回合開始\n";

        // Each player plays to choose an action
        foreach ($this->players as $player) {
            /** @var HumanPlayer|AIPlayer $player */
            $player->chooseAction();
        }

        $this->compareCards();
        $this->endRound();
    }

    public function compareCards(): void
    {
        $maxIndex = 0;

        foreach ($this->players as $index => $player) {
            /** @var HumanPlayer|AIPlayer $player */
            $card = $player->getShowedCard();

            if (empty($max)) {
                $max = $card;
            }

            // Compare card rank and suit
            if ($card->getRank()->value > $max->getRank()->value) {
                $max = $card;
                $maxIndex = $index;
            } elseif ($card->getRank()->value == $max->getRank()->value) {
                if ($card->getSuit()->value > $max->getSuit()->value) {
                    $max = $card;
                    $maxIndex = $index;
                }
            }
        }

        if (empty($max)) {
            echo "本回合無人出牌\n";
        } else {
            $suit = $max->getSuit()->toCardString();
            $rank = $max->getRank()->toCardString();

            /** @var HumanPlayer|AIPlayer $winner */
            $winner = $this->players[$maxIndex];
            $winner->gainPoint();

            echo "本回合贏家為：{$winner->getName()}, 目前得分為：{$winner->getPoint()}  ";
            echo "最大的牌為：$suit $rank\n";
        }
    }

    public function endRound(): void
    {
        // Countdown exchange hands
        $exchangeHands = $this->getExchangeHands();
        if (count($exchangeHands) !== 0) {
            foreach ($exchangeHands as $exchangeHand) {
                /** @var ExchangeHands $exchangeHand */
                $exchangeHand->countdown();
                if ($exchangeHand->getDuration() === 0) {
                    $this->removeExchangeHands($exchangeHand);
                }
            }
        }

        echo "第{$this->round}回合結束\n";
        $this->round++;
        $this->round > 13 ? $this->endGame() : $this->startRound();
    }

    private function endGame(): void
    {
        $winners = $this->compareScoreWithPlayers($this->players);

        echo "遊戲結束, 贏家為：\n";
        foreach ($winners as $winner) {
            echo "{$winner->getName()}, 得分為：{$winner->getPoint()} \n";
        }
    }

    public function compareScoreWithPlayers(array $players): array
    {
        $players = array_map(fn ($player) => $player->getPoint(), $players);
        $max = max($players);

        // Winner may be more than one
        return array_filter($this->players,
            fn ($player) => $player->getPoint() === $max);
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getExchangeHands(): array
    {
        return $this->exchangeHands;
    }

    public function addExchangeHands(ExchangeHands $exchangeHands): void
    {
        $this->exchangeHands[] = $exchangeHands;
    }

    public function removeExchangeHands(ExchangeHands $exchangeHands): void
    {
        $filtered = array_filter($this->exchangeHands,
            fn ($exchangeHand) => $exchangeHand !== $exchangeHands);
        $this->exchangeHands = array_values($filtered);
    }
}
