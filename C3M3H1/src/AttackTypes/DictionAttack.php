<?php

namespace C3M3H1\AttackTypes;

use C3M3H1\MapObjects\Obstacle;
use C3M3H1\MapObjects\Roles\Character;
use C3M3H1\MapObjects\Roles\Role;

class DictionAttack extends AttackType
{
    /**
     * 取得單個方向的所有物件, 並檢查是否有可攻擊的物件, 當遇到障礙物後停止搜尋
     */
    public function attackable(): bool
    {
        /** @var Character $role */
        $role = $this->getRole();
        $direction = $role->getDirection();

        [$x, $y] = $direction->toRange();
        $coordinate = $role->getCoordinate();

        $findCondition = fn ($object) => $object instanceof Role;
        $breakCondition = fn ($object) => $object instanceof Obstacle;

        return $coordinate->existDirectionByCondition($x, $y, $findCondition, $breakCondition);
    }

    public function attack(): void
    {
        /** @var Character $role */
        $role = $this->getRole();
        $direction = $role->getDirection();

        [$x, $y] = $direction->toRange();
        $coordinate = $role->getCoordinate();

        $findCondition = fn ($object) => $object instanceof Role;
        $breakCondition = fn ($object) => $object instanceof Obstacle;

        $targets = $coordinate->findDirectionByCondition($x, $y, $findCondition, $breakCondition);

        if (! count($targets)) {
            echo "No target to attack!\n";

            return;
        }

        $power = $role->getAttack();

        /** @var Role $target */
        $targetCoordinate = $targets[0];
        $target = $targetCoordinate->getObject();
        $target->onAttack($power);
    }
}
