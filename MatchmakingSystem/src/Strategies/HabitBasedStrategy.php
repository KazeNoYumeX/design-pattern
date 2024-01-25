<?php

namespace MatchmakingSystem\Strategies;

use MatchmakingSystem\Individual;
use MatchmakingSystem\Interfaces\Strategy;

class HabitBasedStrategy implements Strategy
{
    private readonly string $name;

    public function __construct()
    {
        $this->name = '興趣先決 (Habit-Based)';
    }

    public function sortConditions(Individual $individual, array $conditions): array
    {
        $habits = $individual->getHabits();
        $habits = array_map(fn ($habit) => $habit->getName(), $habits);

        usort($conditions, function ($left, $right) use ($habits) {
            $leftHabits = $left->getHabits();
            $leftHabits = array_map(fn ($habit) => $habit->getName(), $leftHabits);

            $rightHabits = $right->getHabits();
            $rightHabits = array_map(fn ($habit) => $habit->getName(), $rightHabits);

            $leftCount = count(array_intersect($habits, $leftHabits));
            $rightCount = count(array_intersect($habits, $rightHabits));

            // If the number of habits is the same, sort by id
            if ($leftCount === $rightCount) {
                return $left->getId() <=> $right->getId();
            }

            return $rightCount <=> $leftCount;
        });

        return $conditions;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
