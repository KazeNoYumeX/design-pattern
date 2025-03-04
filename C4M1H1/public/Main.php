<?php

declare(strict_types=1);

use C4M1H1\FileLoaders\FileLoader;
use C4M1H1\FileLoaders\Hero;
use C4M1H1\FileLoaders\Strategies\AISeedDecisionStrategy;
use C4M1H1\FileLoaders\Strategies\CommandLineStrategy;
use C4M1H1\FileLoaders\Unit;
use C4M1H1\PatientDatabase;
use C4M1H1\Skills\Cheerup;
use C4M1H1\Skills\Curse;
use C4M1H1\Skills\Fireball;
use C4M1H1\Skills\Handler\CheerupStatusHandler;
use C4M1H1\Skills\Handler\NormalStatusHandler;
use C4M1H1\Skills\Handler\OverHpHandler;
use C4M1H1\Skills\Handler\PetrochemicalStatusHandler;
use C4M1H1\Skills\Handler\PoisonedHandler;
use C4M1H1\Skills\OnePunch;
use C4M1H1\Skills\Petrochemical;
use C4M1H1\Skills\Poison;
use C4M1H1\Skills\SelfExplosion;
use C4M1H1\Skills\SelfHealing;
use C4M1H1\Skills\Summon;
use C4M1H1\States\Normal;

use function Pest\Faker\fake;

require_once dirname(__DIR__).'/vendor/autoload.php';

$patients = dirname(__DIR__).'/data/patient.json';
$potentialDiseases = dirname(__DIR__).'/data/potential-disease.txt';
$databases = new PatientDatabase($patients, $potentialDiseases);

dd($patients, $potentialDiseases);

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
        new FileLoader,
    ];

    shuffle($skills);

    return array_slice($skills, 0, $number);
}
