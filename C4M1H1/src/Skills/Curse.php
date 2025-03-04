<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\EnemyPickStrategy;
use C3MB\Units\Observers\CurseObserver;
use C3MB\Units\Unit;

class Curse extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('詛咒', new EnemyPickStrategy($this), 100);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        // Curse the target
        $executor = $this->getExecutor();
        $observer = new CurseObserver($executor, $executor);
        $effect = fn (Unit $target) => $target->register($observer);
        $this->effectTargets($effect);
    }
}
