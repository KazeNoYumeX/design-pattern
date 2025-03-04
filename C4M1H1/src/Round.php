<?php

namespace C3MB;

use C3MB\Skills\Action;
use C3MB\States\State;
use C3MB\Units\Hero;
use C3MB\Units\Unit;

class Round
{
    public function __construct(
        private readonly Battle $battle,
        private int $num = 0,
    ) {}

    public function init(array $options): void
    {
        $battle = $this->getBattle();
        $troops = $battle->getTroops();

        /** @var Troop $troop */
        foreach ($troops as $troop) {
            $option = array_shift($options);

            /** @var State $state */
            [
                'hp' => $hp,
                'mp' => $mp,
                'str' => $str,
                'state' => $state,
                'skills' => $skills
            ] = $option;

            // Set the troop's units' stats
            foreach ($troop->units as $unit) {
                /** @var Unit $unit */
                $unit->setHp($hp)
                    ->setMp($mp)
                    ->setStr($str)
                    ->setState($state);

                if (! $unit instanceof Hero) {
                    $unit->setSkills($skills);
                }
            }
        }

        echo "遊戲開始\n";

        $this->start();
    }

    public function getBattle(): Battle
    {
        return $this->battle;
    }

    public function start(): void
    {
        // Plus the turn number and show the turn number
        $turn = $this->addTurn();
        echo "第{$turn}回合開始\n";

        // Each map object takes a start action
        $endBattle = $this->troopUnitTakeAction();

        // If the end condition is met, end the battle
        if ($endBattle) {
            $this->battle->end();

            return;
        }

        // End the round
        $this->end();
    }

    public function addTurn(): int
    {
        $turn = $this->getNum() + 1;
        $this->setNum($turn);

        return $turn;
    }

    private function getNum(): int
    {
        return $this->num;
    }

    private function setNum(int $num): void
    {
        $this->num = $num;
    }

    private function troopUnitTakeAction(): bool
    {
        $battle = $this->getBattle();
        $troops = $battle->getTroops();

        // Each troop takes a turn
        foreach ($troops as $troop) {
            /** @var Troop $troop */
            $units = $troop->getAliveUnits();

            for ($i = 0; $i < count($units); $i++) {
                /** @var Unit $unit */
                $unit = $units[$i] ?? null;

                // Invalid unit or unit is dead will skip
                if (! $unit) {
                    continue;
                }

                // Show the unit status
                $unit->showStatus();

                // (S1) Pick the action
                $action = $unit->takeAction();

                // (S2) Pick the target
                if (! $action instanceof Action) {
                    continue;
                }

                // If the action need target, pick the target
                $action->pickTarget($troops);

                // (S3) Execute the action
                $action->execute();

                // After the action, end the action
                $unit->endAction();

                // Re-fetch the alive units to include any newly summoned units
                $units = $troop->getAliveUnits();

                // Check the end condition
                if ($battle->endCondition()) {
                    return true;
                }
            }
        }

        return false;
    }

    public function end(): void
    {
        echo "第{$this->num}回合結束\n";

        $this->start();
    }
}
