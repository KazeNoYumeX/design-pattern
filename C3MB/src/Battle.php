<?php

namespace C3MB;

use C3MB\Units\Unit;

class Battle
{
    protected Round $round;

    protected ?RPG $game = null;

    public function __construct(
        protected array $troops = [],
    ) {
        $this->round = new Round($this);
    }

    public function attend(Unit $unit, int $troopId = 1): void
    {
        // find the troop
        $troop = $this->findTroop($troopId);

        // if not found, create a new troop
        if ($troop === null) {
            $this->createTroop($unit);

            return;
        }

        // Add the unit to the troop
        $troop->addUnit($unit);
    }

    private function findTroop(int $troopId): ?Troop
    {
        foreach ($this->troops as $troop) {
            /** @var Troop $troop */
            if ($troop->getId() === $troopId) {
                return $troop;
            }
        }

        return null;
    }

    private function createTroop(Unit $unit): void
    {
        $troopId = $this->findLastTroopId() + 1;
        $troop = new Troop($this, $troopId);
        $troop->addUnit($unit);

        // Add the troop to the troops
        $this->addTroop($troop);
    }

    private function findLastTroopId(): int
    {
        $troops = $this->getTroops();

        $num = count($troops);
        if ($num === 0) {
            return 0;
        }

        $troop = $troops[$num - 1];

        return $troop->getId();
    }

    public function getTroops(): array
    {
        return $this->troops;
    }

    private function addTroop(Troop $troop): void
    {
        $this->troops[] = $troop;
    }

    public function endCondition(): bool
    {
        // Any troops annihilated
        $troops = $this->getTroops();
        foreach ($troops as $troop) {
            /** @var Troop $troop */
            if ($troop->annihilated()) {
                return true;
            }
        }

        $hero = $this->game->getHero();

        return $hero?->dead() ?? false;
    }

    public function setGame(RPG $param): void
    {
        $this->game = $param;
    }

    public function start(array $options): void
    {
        $this->round->init($options);
    }

    public function end(): void
    {
        $this->game->end();
    }
}
