<?php

namespace C3M3H1;

class Game
{
    protected Round $round;

    public function __construct(
        private readonly Map $map,
    ) {
        $this->round = new Round($this);
    }

    public function showMap(): void
    {
        $this->map->showMap();
    }

    public function getMap(): Map
    {
        return $this->map;
    }

    public function start(): void
    {
        $this->round->init();
    }

    public function init(array $mapObjects): void
    {
        $canInit = $this->map->validateMapObjects($mapObjects);
        if (! $canInit) {
            return;
        }

        $this->map->generateMapObjects($mapObjects);
    }

    public function end(): void
    {
        echo '遊戲結束';
    }

    public function endCondition(): bool
    {
        $monsters = $this->map->findAvailableMonster();

        return $monsters === [];
    }

    public function randomGenerate(): void
    {
        $this->map->randomGenerate();
    }
}
