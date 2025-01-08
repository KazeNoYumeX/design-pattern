<?php

namespace C3MB\Units\Strategies;

class AISeedDecisionStrategy implements Strategy
{
    public function __construct(
        private int $seed = 0,
    ) {}

    public function chooseAction(array $options): int
    {
        $decision = $this->seed % count($options);

        $this->increase();

        return $decision;
    }

    public function increase(): void
    {
        $this->seed++;
    }

    public function chooseTarget(array $options, int $num = 1): array
    {
        $decisions = [];

        for ($i = 0; $i < $num; $i++) {
            $decision = ($this->seed + $i) % count($options);
            $decisions[] = $decision;
        }

        $this->increase();

        return array_map(fn ($key) => $options[$key], $decisions);
    }
}
