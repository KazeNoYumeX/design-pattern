<?php

namespace C3M3H1;

use C3M3H1\MapObjects\MapObject;

class Round
{
    public function __construct(
        private readonly Game $game,
        private int $num = 0,
    ) {}

    public function init(): void
    {
        echo "遊戲開始\n";
        $this->start();
    }

    public function start(): void
    {
        // Plus the turn number and show the turn number
        $turn = $this->addTurn();
        echo "第{$turn}回合開始\n";

        $game = $this->getGame();

        echo "顯示地圖物件\n";
        $game->showMap();

        echo "隨機生成\n";
        $game->randomGenerate();

        echo "顯示生成後地圖物件\n";
        $game->showMap();

        echo "地圖物件行動\n";
        $this->mapObjectsTakeAction();

        $this->end();
    }

    public function addTurn(): int
    {
        $turn = $this->getNum() + 1;
        $this->setNum($turn);

        return $turn;
    }

    private function getNum(): int
    {
        return $this->num;
    }

    private function setNum(int $num): void
    {
        $this->num = $num;
    }

    public function getGame(): Game
    {
        return $this->game;
    }

    private function mapObjectsTakeAction(): void
    {
        // Each map object takes a turn
        $mapObjects = $this->getSortedMapObjects();

        foreach ($mapObjects as $mapObject) {
            /** @var MapObject $mapObject */
            $mapObject->takeAction();
        }
    }

    private function getSortedMapObjects(): array
    {
        $mapObjects = $this->game->getMap()->getMapObjects();

        return $this->sortMapObjectAction($mapObjects);
    }

    public function sortMapObjectAction(array $mapObjects): array
    {
        // Sort by type, character first, then monster, then others
        usort($mapObjects, function ($former, $latter) {
            $formerOption = $former->getOption();
            $formerPriority = $this->getPriority($formerOption);

            $latterOption = $latter->getOption();
            $latterPriority = $this->getPriority($latterOption);

            return $formerPriority <=> $latterPriority;
        });

        return $mapObjects;
    }

    private function getPriority(MapOption $option): int
    {
        if ($option->operable()) {
            return 1;
        }

        return $option->movable() ? 2 : 3;
    }

    public function end(): void
    {
        echo "第{$this->num}回合結束\n";

        // Each map object takes a end action
        $mapObjects = $this->getSortedMapObjects();
        foreach ($mapObjects as $mapObject) {
            /** @var MapObject $mapObject */
            $mapObject->endAction();
        }

        $game = $this->getGame();
        if ($game->endCondition()) {
            $game->end();

            return;
        }

        $this->start();
    }
}
