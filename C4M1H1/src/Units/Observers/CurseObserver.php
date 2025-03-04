<?php

namespace C3MB\Units\Observers;

use C3MB\Units\Unit;

class CurseObserver implements ProhibitDuplicate, UnitObserver
{
    use WithDuplicate;

    public function __construct(
        protected Unit $curser,
        protected Unit $cursee,
    ) {
        $key = $curser->getTroopId().'-'.$curser->getId();
        $this->setUniqueKey(self::class)
            ->setUniqueValue($key);
    }

    public function update(): void
    {
        if ($this->executed()) {
            return;
        }

        $cursee = $this->cursee;

        if ($cursee->dead()) {
            // If the curser is still alive, heal the curser
            if ($this->curser->alive()) {
                $mp = $cursee->getMp();
                $this->curser->heal($mp);
            }

            // Remove the observer from cursee
            $this->cursee->unregister($this);
        }
    }
}
