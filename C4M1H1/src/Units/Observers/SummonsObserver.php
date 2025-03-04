<?php

namespace C3MB\Units\Observers;

use C3MB\Units\Unit;

class SummonsObserver implements UnitObserver
{
    public function __construct(
        protected Unit $summoner,
        protected Unit $summon
    ) {}

    public function update(): void
    {
        $summon = $this->summon;

        if ($summon->dead()) {
            // If the summoner is still alive, heal the summoner
            if ($this->summoner->alive()) {
                $this->summoner->heal(30);
            }

            // Remove the observer from summon
            $this->summon->unregister($this);
        }
    }
}
