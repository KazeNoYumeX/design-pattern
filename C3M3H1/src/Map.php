<?php

namespace C3M3H1;

use C3M3H1\CollisionHandlers\CollisionHandler;
use Exception;

class Map
{
    protected array $coordinates = [];

    public function __construct(
        private readonly int $x,
        private readonly int $y,
    ) {
        $this->initMap();
    }

    public function initMap(): void
    {
        for ($i = 0; $i < $this->y; $i++) {
            for ($j = 0; $j < $this->x; $j++) {
                $this->coordinates[$i][$j] = new Coordinate($i, $j);
            }
        }
    }

    public function showMap(): void
    {
        echo 'Map：' . PHP_EOL;

        foreach ($this->coordinates as $row) {
            foreach ($row as $coordinate) {
                /** @var Coordinate $coordinate */
                $coordinate->showSymbol();
            }

            echo PHP_EOL;
        }
    }

    /**
     * @throws Exception
     */
    public function moveSprite(int $from, int $to): void
    {
        if (empty($this->coordinates[$from]) || empty($this->coordinates[$to])) {
            throw new Exception('Invalid coordinate');
        }

        /** @var Coordinate $former */
        $former = $this->coordinates[$from];

        if (empty($formerSprite = $former->getObject())) {
            throw new Exception('No sprite to move');
        }

        /** @var Coordinate $latter */
        $latter = $this->coordinates[$to];
        $latterSprite = $latter->getObject();

        if ($latterSprite) {
            $handler = $this->getHandler();
            $handler->handle($formerSprite, $latterSprite);
        } else {
            $former->swap($latter);
        }
    }

    public function getHandler(): CollisionHandler
    {
        return $this->collisionHandler;
    }
}
