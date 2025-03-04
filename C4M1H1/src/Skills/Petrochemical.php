<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\EnemyPickStrategy;
use C3MB\States\Petrochemical as PetrochemicalState;
use C3MB\Units\Unit;

class Petrochemical extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('石化', new EnemyPickStrategy($this), 100);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        $effect = fn (Unit $unit) => $unit->enterState(new PetrochemicalState);
        $this->effectTargets($effect);
    }
}
