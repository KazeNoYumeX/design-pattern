<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\NonePickStrategy;
use C3MB\States\Normal;
use C3MB\Units\Observers\SummonsObserver;
use C3MB\Units\Strategies\AISeedDecisionStrategy;
use C3MB\Units\Unit;

class Summon extends Action implements Skill
{
    public function __construct()
    {
        parent::__construct('召喚', new NonePickStrategy($this), 150, 0);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        $executor = $this->getExecutor();
        $troop = $executor->getTroop();
        $summon = $this->summon();
        $troop->addUnit($summon);

        // Create a new observer for summon
        $this->setTargets([$summon]);
        $observer = new SummonsObserver($executor, $summon);
        $effect = fn (Unit $target) => $target->register($observer);
        $this->effectTargets($effect);
    }

    public function summon(): Unit
    {
        $slime = new Unit('Slime', new AISeedDecisionStrategy);
        $slime->setHp(100)
            ->setMp(0)
            ->setStr(50)
            ->setState(new Normal);

        return $slime;
    }
}
