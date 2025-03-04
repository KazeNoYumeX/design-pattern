<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\EnemyPickStrategy;
use C3MB\States\Poisoned;
use C3MB\Units\Unit;

class Poison extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('下毒', new EnemyPickStrategy($this), 80);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        $effect = fn (Unit $unit) => $unit->enterState(new Poisoned);
        $this->effectTargets($effect);
    }
}
