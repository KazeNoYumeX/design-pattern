<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\EnemyPickStrategy;
use C3MB\Units\Unit;

class WaterBall extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('水球', new EnemyPickStrategy($this), 50);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        // Define the 120 power of the WaterBall
        $power = 120;
        $executor = $this->getExecutor();
        $power = $executor->attack($power);

        $effect = fn (Unit $target) => $target->damage($power);
        $this->effectTargets($effect);
    }
}
