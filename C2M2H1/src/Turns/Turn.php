<?php

namespace C2M2H1\Turns;

use C2M2H1\Games\Game;

abstract class Turn
{
    private Game $game;

    private int $num = 0;

    abstract public function init(): void;

    abstract public function start(): void;

    abstract public function end(): void;

    public function getGame(): Game
    {
        return $this->game;
    }

    public function setGame(Game $game): void
    {
        $this->game = $game;
    }

    public function addTurn(): int
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
