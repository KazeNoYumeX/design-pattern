<?php

namespace C2MB;

use C2MB\Players\Player;

class BigTwo
{
    protected array $players;

    public function __construct(
        public readonly Deck $deck,
        protected readonly ?Round $turn = null,
        protected ?Field $field = null
    ) {
        $this->turn?->setGame($this);
    }

    public function end(array $winners): void
    {
        echo "遊戲結束, 贏家為：\n";
        foreach ($winners as $winner) {
            /** @var Player $winner */
            echo "{$winner->getName()} \n";
        }
    }

    public function showInfo(): void
    {
        $players = $this->getPlayers();
        $total = count($players);

        for ($i = 0; $i < $total; $i++) {
            $num = $i + 1;
            echo "玩家{$num}名稱為：".$this->players[$i]->getName()."\n";
        }

        echo "遊戲開始, 玩家總人數為: $total\n";
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function addPlayer(Player $player): void
    {
        $this->players[] = $player;
    }

    public function getTurn(): Round
    {
        return $this->turn;
    }

    public function getField(): ?Field
    {
        return $this?->field;
    }

    public function getDeck(): Deck
    {
        return $this->deck;
    }

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
