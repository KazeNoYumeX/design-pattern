<?php

namespace C3M3H1;

use C3M3H1\Commands\Command;

class Game
{
    protected Round $round;

    public function __construct(
        private readonly Map $map,
    )
    {
    }

    public function showMap(): void
    {
        $this->map->showMap();
    }

    public function init(): void
    {
        $this->round = new Round($this);
    }

}
