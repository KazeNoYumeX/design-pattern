<?php

declare(strict_types=1);

use Faker\Factory;
use Showdown\Coordinate;
use Showdown\Enums\GenderEnum;
use Showdown\Habit;
use Showdown\Individual;
use Showdown\Interfaces\Strategy;
use Showdown\Matches\ReverseMatch;
use Showdown\Matches\StandardMatch;
use Showdown\Matches\SystemMatch;
use Showdown\MatchmakingSystem;
use Showdown\Strategies\DistanceBasedStrategy;
use Showdown\Strategies\HabitBasedStrategy;

require_once dirname(__DIR__).'/vendor/autoload.php';

function initIndividuals(int $num = 20): array
{
    $individuals = [];

    for ($i = 0; $i < $num; $i++) {
        $individuals[] = generateIndividual($i);
    }

    return $individuals;
}

function generateHabits(): array
{
    $faker = Factory::create();

    $habits = [];
    $num = rand(1, 10);

    for ($i = 0; $i < $num; $i++) {
        $name = "Habit {$faker->randomLetter}";
        $habits[] = new Habit($name);
    }

    return $habits;
}

function generateCoordinate(): Coordinate
{
    return new Coordinate(rand(0, 100), rand(0, 100));
}

function getRandomIndividual(array $individuals): Individual
{
    return $individuals[array_rand($individuals)];
}

function generateIndividual(int $id): Individual
{
    $faker = Factory::create();

    $attribute = [
        'id' => $id,
        'gender' => $faker->randomElement(GenderEnum::cases()),
        'age' => rand(18, 40),
        'intro' => $faker->text(),
        'habits' => generateHabits(),
        'coordinate' => generateCoordinate(),
    ];

    return new Individual($attribute);
}

function choseMatchmakingSystem(SystemMatch $match = null): SystemMatch
{
    if ($match) {
        return $match;
    }

    $faker = Factory::create();

    $systems = [
        new StandardMatch(),
        new ReverseMatch(),
    ];

    return $faker->randomElement($systems);
}

function choseStrategy(Strategy $strategy = null): Strategy
{
    if ($strategy) {
        return $strategy;
    }

    $faker = Factory::create();

    $strategies = [
        new DistanceBasedStrategy(),
        new HabitBasedStrategy(),
    ];

    return $faker->randomElement($strategies);
}

$individuals = initIndividuals();
$system = new MatchmakingSystem($individuals);

$match = choseMatchmakingSystem(new ReverseMatch());
$strategy = choseStrategy(new HabitBasedStrategy());
$individual = getRandomIndividual($system->getIndividuals());
$matchIndividual = $system->match($individual, $match, $strategy);

// System output
echo "配對策略: {$match->getName()}\n";
echo "配對條件: {$strategy->getName()}\n\n";

// Individual output
echo "配對結果: \n";
echo "配對人: {$individual->getId()}\n";
echo "資訊: \n";
echo "自我介紹: {$individual->getIntro()}\n";
echo "性別: {$individual->getGender()->value}\n";
echo "年齡: {$individual->getAge()}\n";
echo "興趣: {$individual->getHabit()}\n";
echo "座標: {$individual->getCoordinate()->getPositionToString()}\n\n";

// Match individual output
echo "配對人: {$matchIndividual->getId()}\n";
echo "資訊: \n";
echo "自我介紹: {$matchIndividual->getIntro()}\n";
echo "性別: {$matchIndividual->getGender()->value}\n";
echo "年齡: {$matchIndividual->getAge()}\n";
echo "興趣: {$matchIndividual->getHabit()}\n";
echo "座標: {$matchIndividual->getCoordinate()->getPositionToString()}\n";
