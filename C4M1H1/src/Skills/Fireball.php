<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\EnemyPickStrategy;
use C3MB\Units\Unit;

class Fireball extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('火球', new EnemyPickStrategy($this), 50, 0);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        // Define the 50 power of the Fireball
        $executor = $this->getExecutor();
        $power = $executor->attack(50);
        $effect = fn (Unit $target) => $target->damage($power);
        $this->effectTargets($effect);
    }
}
