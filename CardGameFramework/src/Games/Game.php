<?php

namespace CardGameFramework\Games;

use CardGameFramework\Deck;
use CardGameFramework\Field;
use CardGameFramework\Players\Player;
use CardGameFramework\Turns\Turn;

abstract class Game
{
    protected array $players;

    public function __construct(
        public readonly Deck $deck,
        protected readonly ?Turn $turn = null,
        protected ?Field $field = null
    ) {
        $this->turn?->setGame($this);
    }

    abstract public function endCondition(): bool;

    abstract public function getWinners(): array;

    abstract public function start(): void;

    abstract public function addPlayers(int $player, int $ai): void;

    public function end(array $winners): void
    {
        echo "遊戲結束, 贏家為：\n";
        foreach ($winners as $winner) {
            /** @var Player $winner */
            echo "{$winner->getName()} \n";
        }
    }

    public function init(int $player, int $ai = 0): void
    {
        // Add players to the game
        $this->addPlayers($player, $ai);

        // Show the game information
        $this->showInfo();

        // start the game
        $this->start();
    }

    protected function showInfo(): void
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

    public function getTurn(): Turn
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
}
