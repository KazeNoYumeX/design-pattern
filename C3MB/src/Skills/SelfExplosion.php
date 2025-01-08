<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\AllPickStrategy;
use C3MB\Units\Unit;

class SelfExplosion extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('自爆', new AllPickStrategy($this), 200, 0);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        // The executor will die after the explosion
        $executor = $this->getExecutor();
        $executor->damage($executor->getHp());

        // Define the 150 power of the SelfExplosion
        $power = $executor->attack(150);
        $effect = fn (Unit $target) => $target->damage($power);
        $this->effectTargets($effect);
    }
}
