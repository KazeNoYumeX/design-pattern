<?php

use MatchmakingSystem\Enums\GenderEnum;
use MatchmakingSystem\Individual;
use MatchmakingSystem\Matches\ReverseMatch;
use MatchmakingSystem\Matches\StandardMatch;
use MatchmakingSystem\Strategies\DistanceBasedStrategy;
use MatchmakingSystem\Strategies\HabitBasedStrategy;

use function Pest\Faker\fake;

it('can return the first individual after sorting by StandardMatch', function () {
    $strategy = fake()->randomElement([new DistanceBasedStrategy(), new HabitBasedStrategy()]);
    $match = new StandardMatch();

    // Fake the individuals
    $individuals = [];
    $num = fake()->randomNumber(3, 20);

    for ($i = 0; $i < $num; $i++) {
        $individuals[] = new Individual([
            'id' => $i,
            'gender' => fake()->randomElement(GenderEnum::cases()),
            'age' => fake()->numberBetween(18, 40),
            'intro' => fake()->text(),
        ]);
    }

    $individual = array_shift($individuals);

    // Start finding the best match
    $bestMatch = $match->findBestMatch($individual, $individuals, $strategy);

    // Sort the individuals
    $result = $strategy->sortConditions($individual, $individuals);
    $first = array_shift($result);

    expect($bestMatch)->toBeInstanceOf(Individual::class)
        ->and($bestMatch)->toBe($first);
});

it('can return the end individual after sorting by ReverseMatch', function () {
    $strategy = fake()->randomElement([new DistanceBasedStrategy(), new HabitBasedStrategy()]);
    $match = new ReverseMatch();

    // Fake the individuals
    $individuals = [];
    $num = fake()->randomNumber(3, 20);

    for ($i = 0; $i < $num; $i++) {
        $individuals[] = new Individual([
            'id' => $i,
            'gender' => fake()->randomElement(GenderEnum::cases()),
            'age' => fake()->numberBetween(18, 40),
            'intro' => fake()->text(),
        ]);
    }

    $individual = array_pop($individuals);

    // Start finding the best match
    $bestMatch = $match->findBestMatch($individual, $individuals, $strategy);

    // Sort the individuals
    $result = $strategy->sortConditions($individual, $individuals);
    $end = array_pop($result);

    expect($bestMatch)->toBeInstanceOf(Individual::class)
        ->and($bestMatch)->toBe($end);
});
