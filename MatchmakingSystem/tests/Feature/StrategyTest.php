<?php

use Showdown\Coordinate;
use Showdown\Enums\GenderEnum;
use Showdown\Habit;
use Showdown\Individual;
use Showdown\Strategies\DistanceBasedStrategy;
use Showdown\Strategies\HabitBasedStrategy;
use function Pest\Faker\fake;

it('can sort by distance', function () {
    $individuals = [];
    $strategy = new DistanceBasedStrategy();

    for ($i = 0; $i < 4; $i++) {
        $attribute = [
            'id' => fake()->unique()->numberBetween(1, 4),
            'gender' => fake()->randomElement(GenderEnum::cases()),
            'age' => fake()->numberBetween(18, 40),
            'intro' => fake()->text(),
            'coordinate' => new Coordinate(fake()->numberBetween(0, 100), fake()->numberBetween(0, 100)),
        ];

        $individuals[] = new Individual($attribute);
    }

    $individual = array_pop($individuals);

    // Start doing the sorting
    $result = $strategy->sortConditions($individual, $individuals);

    // The first element should be the closest one
    $first = array_shift($result);
    $end = array_pop($result);

    $individual->getCoordinate()->getPosition();
    [$x, $y] = $individual->getCoordinate()->getPosition();

    $firstPosition = $first->getCoordinate()->getPosition();
    [$firstPositionX, $firstPositionY] = $firstPosition;

    $endPosition = $end->getCoordinate()->getPosition();
    [$endPositionX, $endPositionY] = $endPosition;

    $distanceX = sqrt(pow($x - $firstPositionX, 2) + pow($y - $firstPositionY, 2));
    $distanceY = sqrt(pow($x - $endPositionX, 2) + pow($y - $endPositionY, 2));

    expect($distanceX)->toBeLessThanOrEqual($distanceY);
});

it('can sort by id when distance same', function () {
    $individuals = [];
    $strategy = new DistanceBasedStrategy();

    for ($i = 0; $i < 4; $i++) {
        $attribute = [
            'id' => $i,
            'gender' => fake()->randomElement(GenderEnum::cases()),
            'age' => fake()->numberBetween(18, 40),
            'intro' => fake()->text(),
            'coordinate' => new Coordinate(0, 0),
        ];

        $individuals[] = new Individual($attribute);
    }

    $individual = array_pop($individuals);

    // Start doing the sorting
    $result = $strategy->sortConditions($individual, $individuals);

    // The first element should be the closest one
    $first = array_shift($result);
    $end = array_pop($result);

    expect($first->getId())->toBeLessThan($end->getId());
});

// 興趣先決的策略，可以正確排序興趣
it('can sort by habit', function () {
    $individuals = [];
    $strategy = new HabitBasedStrategy();
    $habits = [];

    for ($i = 0; $i < 4; $i++) {
        $attribute = [
            'id' => fake()->unique()->numberBetween(1, 4),
            'gender' => fake()->randomElement(GenderEnum::cases()),
            'age' => fake()->numberBetween(18, 40),
            'intro' => fake()->text(),
            'habits' => $habits,
        ];

        $individuals[] = new Individual($attribute);
        $habits[] = new Habit((string) $i);
    }

    $individual = array_pop($individuals);

    // Start doing the sorting
    $result = $strategy->sortConditions($individual, $individuals);

    // The first element should be the closest one
    $first = array_shift($result);
    $end = array_pop($result);

    $habits = $individual->getHabits();
    $habits = array_map(fn ($habit) => $habit->getName(), $habits);

    $firstHabits = $first->getHabits();
    $firstHabits = array_map(fn ($habit) => $habit->getName(), $firstHabits);

    $endHabits = $end->getHabits();
    $endHabits = array_map(fn ($habit) => $habit->getName(), $endHabits);

    $firstCount = count(array_intersect($habits, $firstHabits));
    $endCount = count(array_intersect($habits, $endHabits));

    expect($firstCount)->toBeGreaterThan($endCount);
});

it('can sort by id when habit same', function () {
    $individuals = [];
    $strategy = new HabitBasedStrategy();

    for ($i = 0; $i < 4; $i++) {
        $attribute = [
            'id' => fake()->unique()->numberBetween(1, 4),
            'gender' => fake()->randomElement(GenderEnum::cases()),
            'age' => fake()->numberBetween(18, 40),
            'intro' => fake()->text(),
            'habits' => [],
        ];

        $individuals[] = new Individual($attribute);
    }

    $individual = array_pop($individuals);

    // Start doing the sorting
    $result = $strategy->sortConditions($individual, $individuals);

    // The first element should be the closest one
    $first = array_shift($result);
    $end = array_pop($result);

    expect($first->getId())->toBeLessThan($end->getId());
});
