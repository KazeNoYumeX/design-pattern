<?php

namespace C3MB\Skills;

use C3MB\Skills\Strategies\PickStrategy;
use C3MB\Units\Unit;

abstract class Action
{
    protected Unit $executor;

    public function __construct(
        protected string $name,
        protected readonly PickStrategy $strategy,
        protected int $cost = 0,
        protected int $number = 1,
        protected array $targets = [],
    ) {}

    public function execute(): void
    {
        // If the action is a skill, spend MP
        if ($this instanceof Skill) {
            $executor = $this->getExecutor();
            $executor->spendMp($this->getCost());
        }
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function validAction(Action $action): bool
    {
        $executor = $this->executor;

        $mp = $executor->getMp();

        return $action->getCost() <= $mp;
    }

    public function getCost(): int
    {
        return $this->cost;
    }

    public function pickTarget(array $troops): void
    {
        $targets = $this->strategy->pickTarget($troops);

        $this->setTargets($targets);
    }

    public function setTargets(array $targets): void
    {
        $this->targets = $targets;
    }

    public function effectTargets(callable $effect): void
    {
        $targets = $this->getTargets();

        // Show the targets
        $this->printTargets($targets);

        foreach ($targets as $target) {
            /** @var Unit $target */
            $effect($target);
        }
    }

    private function getTargets(): array
    {
        return $this->targets;
    }

    private function printTargets(array $targets): void
    {
        $targetNames = array_map(fn (Unit $unit) => $unit->getName(), $targets);
        $targetNames = implode(', ', $targetNames);

        $executor = $this->getExecutor();
        echo "{$executor->getName()} 對 $targetNames 使用了 {$this->name}。\n";
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExecutor(): Unit
    {
        return $this->executor;
    }

    public function setExecutor(Unit $unit): void
    {
        $this->executor = $unit;
    }
}
