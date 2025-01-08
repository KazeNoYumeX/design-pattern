<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\AllyPickStrategy;
use C3MB\States\Cheerup as CheerupState;
use C3MB\Units\Unit;

class Cheerup extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('鼓舞', new AllyPickStrategy($this), 100, 3);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        $effect = fn (Unit $unit) => $unit->enterState(new CheerupState);
        $this->effectTargets($effect);
    }
}
