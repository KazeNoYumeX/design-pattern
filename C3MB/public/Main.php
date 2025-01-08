<?php

declare(strict_types=1);

use C3MB\Battle;
use C3MB\RPG;
use C3MB\Skills\Cheerup;
use C3MB\Skills\Curse;
use C3MB\Skills\Fireball;
use C3MB\Skills\Handler\CheerupStatusHandler;
use C3MB\Skills\Handler\NormalStatusHandler;
use C3MB\Skills\Handler\OverHpHandler;
use C3MB\Skills\Handler\PetrochemicalStatusHandler;
use C3MB\Skills\Handler\PoisonedHandler;
use C3MB\Skills\OnePunch;
use C3MB\Skills\Petrochemical;
use C3MB\Skills\Poison;
use C3MB\Skills\SelfExplosion;
use C3MB\Skills\SelfHealing;
use C3MB\Skills\Summon;
use C3MB\Skills\WaterBall;
use C3MB\States\Normal;
use C3MB\Units\Hero;
use C3MB\Units\Strategies\AISeedDecisionStrategy;
use C3MB\Units\Strategies\CommandLineStrategy;
use C3MB\Units\Unit;

use function Pest\Faker\fake;

require_once dirname(__DIR__).'/vendor/autoload.php';

$game = new RPG;
$battle = new Battle;

$skills = generateSkills(fake()->numberBetween(1, 5));

// Or you can use the following code to bind the skills
// $skills = [new Summon, new Fireball];

$hero = new Hero('英雄', new CommandLineStrategy, $skills);
$game->setHero($hero);
$battle->attend($hero);

$units = generateUnits();
foreach ($units as $unit) {
    $battle->attend($unit['unit'], $unit['troopId']);
}

$unitStats = generateUnitStats();
$game->startBattle($battle, $unitStats);

function generateUnit(int $number, int $troopId): array
{
    $units = [];
    $strategy = new AISeedDecisionStrategy;

    for ($i = 0; $i < $number; $i++) {
        $name = fake()->name();
        $unit = new Unit($name, $strategy);

        $units[] = [
            'unit' => $unit,
            'troopId' => $troopId,
        ];
    }

    return $units;
}

function generateUnits(int $ally = -1, int $enemy = -1): array
{
    if ($ally === -1) {
        $ally = fake()->numberBetween(1, 5);
    }

    if ($enemy === -1) {
        $enemy = fake()->numberBetween(1, 5);
    }

    $allys = generateUnit($ally, 1);
    $enemies = generateUnit($enemy, 2);

    return array_merge($allys, $enemies);
}

function generateUnitStats(int $troops = 2): array
{
    $stats = [];

    for ($i = 0; $i < $troops; $i++) {
        $stats[] = [
            'hp' => fake()->numberBetween(1000, 5000),
            'mp' => fake()->numberBetween(1000, 5000),
            'str' => fake()->numberBetween(1, 100),
            'state' => new Normal,
            'skills' => generateSkills(fake()->numberBetween(0, 3)),
        ];
    }

    return $stats;
}

function generateSkills(int $number): array
{
    $handlers = [
        OverHpHandler::class,
        PoisonedHandler::class,
        PetrochemicalStatusHandler::class,
        CheerupStatusHandler::class,
        NormalStatusHandler::class,
    ];

    $skills = [
        new Cheerup,
        new Curse,
        new Fireball,
        new OnePunch($handlers),
        new Petrochemical,
        new Poison,
        new SelfExplosion,
        new SelfHealing,
        new Summon,
        new WaterBall,
    ];

    shuffle($skills);

    return array_slice($skills, 0, $number);
}
