<?php

namespace C3M3H1\Roles;

use C3M3H1\Coordinate;

class Monster extends Role
{
    public function __construct(
        public Coordinate $coordinate
    ) {
        parent::__construct($coordinate);
        $this->setSymbol('F');
    }
}
