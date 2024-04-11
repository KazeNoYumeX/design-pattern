<?php

namespace C3M3H1\States;

class Teleport extends State
{
    public function __construct()
    {
        $this->name = '瞬身';
        $this->setDuration(1);
    }

    public function onEndAction(): void
    {
        $role = $this->role;
        $coordinate = $role->getCoordinate();
        $map = $coordinate->getMap();

        $coordinates = $map->findEmptyCoordinates();
        $nextCoordinate = $map->pickRandomCoordinate($coordinates);

        $coordinate->swap($nextCoordinate);

        parent::onEndAction();
    }
}
