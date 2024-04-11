<?php

namespace C3M3H1\Enums;

use C3M3H1\MapObjects\MapObject;
use C3M3H1\MapObjects\Obstacle;
use C3M3H1\MapObjects\Roles\Character;
use C3M3H1\MapObjects\Roles\Monster;
use C3M3H1\MapObjects\Treasure;

enum MapObjectEnum: int
{
    case CHARACTER = 0;
    case MONSTER = 1;
    case OBSTACLE = 2;
    case TREASURE = 3;

    public function toMapObject(): MapObject
    {
        return match ($this) {
            self::CHARACTER => new Character,
            self::MONSTER => new Monster,
            self::OBSTACLE => new Obstacle,
            self::TREASURE => new Treasure,
        };
    }
}
