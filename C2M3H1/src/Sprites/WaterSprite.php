<?php

namespace C2M3H1\Sprites;

use C2M3H1\Coordinate;

class WaterSprite extends Sprite
{
    public function __construct(
        public Coordinate $coordinate
    ) {
        parent::__construct($coordinate);
        $this->setSymbol('W');
    }
}
