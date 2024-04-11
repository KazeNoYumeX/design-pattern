<?php

namespace C3M3H1\AttackTypes;

use C3M3H1\MapObjects\Roles\Monster;
use C3M3H1\MapObjects\Roles\Role;

class Attack extends AttackType
{
    /**
     * 鄰近座標中的物件是否可以被攻擊
     */
    public function attackable(): bool
    {
        $role = $this->getRole();
        $coordinate = $role->getCoordinate();
        $condition = fn ($role) => $role instanceof Role;

        /** @var Monster $role */
        $range = $role->getAttackRange();

        return $coordinate->existNearbyCondition($range, $range, $range, $condition);
    }

    public function attack(): void
    {
        $role = $this->getRole();
        $coordinate = $role->getCoordinate();

        /** @var Monster $role */
        $range = $role->getAttackRange();

        $condition = fn ($role) => $role instanceof Role;
        $targets = $coordinate->findNearbyCondition($range, $range, $range, $condition);

        if (! count($targets)) {
            echo "No target to attack!\n";

            return;
        }

        $option = $role->getOption();
        if (! $option->operable()) {
            $targetCoordinate = $targets[0];
        } else {
            // TODO This part is operated by the user
            return;
        }

        $power = $role->getAttack();

        /** @var Role $target */
        $target = $targetCoordinate->getObject();
        $target->onAttack($power);
    }
}
