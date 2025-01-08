<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\SelfPickStrategy;
use C3MB\Units\Unit;

class SelfHealing extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('自我治療', new SelfPickStrategy($this), 50, 0);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        $this->effectTargets(fn (Unit $unit) => $unit->heal(50));
    }
}
