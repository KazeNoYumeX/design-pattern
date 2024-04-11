<?php

namespace C3M3H1\AttackTypes;

use C3M3H1\MapObjects\Roles\Role;

class FullRangeAttack extends AttackType
{
    /**
     * 全圖攻擊因此必定 True, 因遊戲設計上不會有無怪物可攻擊的情況
     */
    public function attackable(): bool
    {
        return true;
    }

    public function attack(): void
    {
        $coordinate = $this->role->getCoordinate();
        $map = $coordinate->getMap();

        $coordinates = $map->getCoordinates();
        foreach ($coordinates as $coordinate) {
            $object = $coordinate->getObject();

            if ($object instanceof Role && $object !== $this->role) {
                $power = $this->role->getAttack();
                $object->onAttack($power);
            }
        }
    }
}
