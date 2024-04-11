<?php

namespace C3M3H1\States;

class Teleport extends State
{
    public function __construct()
    {
        parent::__construct('瞬身');
    }

    public function onEndAction(): void
    {
        $role = $this->role;
        $coordinate = $role->getCoordinate();
        $map = $coordinate->getMap();

        $coordinates = $map->findEmptyCoordinates();
        $nextCoordinate = $map->pickRandomCoordinate($coordinates);

        // Swap the role's coordinate with the next coordinate
        $coordinate->swap($nextCoordinate);

        parent::onEndAction();
    }
}
