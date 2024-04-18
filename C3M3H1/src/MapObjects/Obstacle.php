<?php

namespace C3M3H1\MapObjects;

use C3M3H1\Coordinate;

class Obstacle extends MapObjects
{
    public function __construct(
        public Coordinate $coordinate
    ) {
        parent::__construct($coordinate);
        $this->setSymbol('W');
    }
}
