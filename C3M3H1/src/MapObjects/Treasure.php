<?php

namespace C3M3H1\MapObjects;

use C3M3H1\Enums\TreasureType;
use C3M3H1\MapObjects\Roles\Role;

class Treasure extends MapObject
{
    protected TreasureType $type;

    public function __construct(?TreasureType $type = null)
    {
        if (! $type instanceof TreasureType) {
            $type = TreasureType::generateTreasureType();
        }

        $this->setSymbol('x')
            ->setType($type);
    }

    public function effect(Role $role): void
    {
        $type = $this->getType();

        echo "$role->name 觸碰到了寶藏，獲得了 {$type->toTreasureName()} \n";

        $role->enterState($type->toState());

        // After the role get the treasure, the treasure will disappear
        $this->dead();
    }

    public function getType(): TreasureType
    {
        return $this->type;
    }

    public function setType(TreasureType $type): void
    {
        $this->type = $type;
    }
}
