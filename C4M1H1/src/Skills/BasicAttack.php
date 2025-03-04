<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\EnemyPickStrategy;
use C3MB\Units\Unit;

class BasicAttack extends Action
{
    public function __construct()
    {
        parent::__construct('普通攻擊', new EnemyPickStrategy($this));
    }

    public function execute(): void
    {
        $executor = $this->getExecutor();

        // Use unit's strength to calculate the damage
        $power = $executor->attack();
        $effect = fn (Unit $target) => $target->damage($power);
        $this->effectTargets($effect);
    }
}
