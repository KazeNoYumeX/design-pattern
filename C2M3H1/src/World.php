<?php

namespace C2M3H1;

use C2M3H1\CollisionHandlers\CollisionHandler;
use Exception;

readonly class World
{
    public function __construct(
        public array $coordinates,
        private CollisionHandler $collisionHandler
    ) {
    }

    public function showMap(): void
    {
        echo 'World：';

        foreach ($this->coordinates as $coordinate) {
            /** @var Coordinate $coordinate */
            $coordinate->showSymbol();
        }

        echo "\n";
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
