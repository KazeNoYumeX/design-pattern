<?php

namespace C3MB\Units;

use C3MB\Skills\Action;
use C3MB\Skills\BasicAttack;
use C3MB\States\State;
use C3MB\Troop;
use C3MB\Units\Observers\ProhibitDuplicate;
use C3MB\Units\Observers\UnitObserver;
use C3MB\Units\Strategies\Strategy;

class Unit
{
    public State $state;

    protected int $id;

    protected ?Troop $troop = null;

    protected array $observers = [];

    private int $hp = 0;

    private int $mp = 0;

    private int $str = 0;

    public function __construct(
        protected string $name,
        protected Strategy $strategy,
        protected array $skills = [],
    ) {}

    public function register(UnitObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function unregister(UnitObserver $observer): void
    {
        $observers = $this->getObservers();
        $key = array_search($observer, $observers);

        if ($key === false) {
            return;
        }

        // Unregister the observer
        unset($observers[$key]);
        $observers = array_values($observers);
        $this->setObservers($observers);
    }

    public function getObservers(): array
    {
        return $this->observers;
    }

    private function setObservers(array $observers): void
    {
        $this->observers = $observers;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTroop(): Troop
    {
        return $this->troop;
    }

    public function setTroop(Troop $troop): static
    {
        $this->troop = $troop;

        return $this;
    }

    public function alive(): bool
    {
        return ! $this->dead();
    }

    public function dead(): bool
    {
        return $this->hp <= 0;
    }

    public function setStr(int $str): static
    {
        $this->str = $str;

        return $this;
    }

    public function enterState(State $state): void
    {
        $this->setState($state->enterState($this));
    }

    public function setSkills(array $skills): static
    {
        $this->skills = $skills;

        return $this;
    }

    public function damage(int $damage): void
    {
        // If the unit is dead, return
        if ($this->dead()) {
            return;
        }

        // The hero get the damage
        $hp = max(0, $this->getHp() - $damage);
        $this->setHp($hp);

        // Output the damage and left hp
        if ($this->dead()) {
            echo "$this->name 死亡。\n";

            $this->deadNotify();
        }
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function setHp(int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    public function deadNotify(): void
    {
        $executed = [];

        $observers = $this->getObservers();
        foreach ($observers as $observer) {
            if ($observer instanceof ProhibitDuplicate) {
                $observer->validateExecuted($executed);
            }

            /** @var UnitObserver $observer */
            $observer->update();

            if ($observer instanceof ProhibitDuplicate) {
                $executed[] = $observer->getUniqueAttribute();
            }
        }
    }

    public function takeAction(): ?Action
    {
        $actions = $this->getActions();
        $actions = $this->state->onTakeAction($actions);

        // If the actions is empty, return null
        if (empty($actions)) {
            return null;
        }

        $idx = $this->chooseAction($actions);
        $action = $actions[$idx];

        /** @var Action $action */
        $action->setExecutor($this);
        $valid = $action->validAction($action);
        if (! $valid) {
            echo "你缺乏 MP，不能進行此行動。\n";

            return $this->takeAction();
        }

        return $action;
    }

    public function getActions(): array
    {
        $actions = [
            new BasicAttack,
        ];

        $skills = $this->getSkills();

        return array_merge($actions, $skills);
    }

    private function getSkills(): array
    {
        return $this->skills;
    }

    public function chooseAction(array $options): int
    {
        return $this->strategy->chooseAction($options);
    }

    public function chooseTarget(array $options, int $num): array
    {
        return $this->strategy->chooseTarget($options, $num);
    }

    public function attack(int $power = 0): int
    {
        if (! $power) {
            $power = $this->getStrength();
        }

        return $this->state->onAttack($power);
    }

    public function getStrength(): int
    {
        return $this->str;
    }

    public function heal(int $heal = 10): void
    {
        $heal = $this->state->onHeal($heal);

        $hp = $this->getHp();
        $this->setHp($hp + $heal);
    }

    public function endAction(): void
    {
        $this->state->onEndAction();
    }

    public function showStatus(): void
    {
        $state = $this->state;
        $troopId = $this->getTroopId();
        echo "輪到 [$troopId]$this->name (HP: $this->hp, MP: $this->mp, STR: $this->str, State: $state->name)。\n";
    }

    public function getTroopId(): int
    {
        return $this->troop->getId();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getMp(): int
    {
        return $this->mp;
    }

    public function setMp(mixed $mp): static
    {
        $this->mp = $mp;

        return $this;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function setState(State $param): static
    {
        $this->state = $param;

        return $this;
    }

    public function spendMp(int $getCost): void
    {
        $mp = $this->getMp();

        $this->setMp($mp - $getCost);
    }
}
