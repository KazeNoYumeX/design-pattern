<?php

declare(strict_types=1);

use C3M3H1\Enums\MapObjectEnum;
use C3M3H1\Game;
use C3M3H1\Map;
use C3M3H1\MapOption;

use function Pest\Faker\fake;

require_once dirname(__DIR__).'/vendor/autoload.php';

$map = new Map(5, 5);
$game = new Game($map);

$mapObjects = generateMapObjects();

// Generate the map objects
$game->init($mapObjects);
$game->start();

function generateMapOptions(bool $operable = false, bool $movable = false, bool $generable = false, int $number = 0, float $rate = 0.0): MapOption
{
    $option = new MapOption;

    $option->setOperable($operable)
        ->setMovable($movable)
        ->setGenerable($generable);

    if ($generable) {
        $option->setGenerableOptions([
            'number' => $number,
            'rate' => $rate,
        ]);
    }

    return $option;
}

function generateMapObjects(int $controllable = 1, int $enemy = 2): array
{
    $controllableOption = generateMapOptions(false, true);

    // Randomly generate the number of monsters
    $monsterOptionNumbers = 0;
    $monsterOption = generateMapOptions(false, true, true, $monsterOptionNumbers, 0.1);

    $obstacle = fake()->numberBetween(1, 5);
    $obstacleOption = generateMapOptions();

    $treasure = fake()->numberBetween(1, 10);

    // Randomly generate the number of treasures
    $treasureOptionNumbers = 1;
    $treasureOption = generateMapOptions(generable: true, number: $treasureOptionNumbers, rate: 0.4);

    return [
        generateMapObject(MapObjectEnum::CHARACTER, $controllable, $controllableOption),
        generateMapObject(MapObjectEnum::MONSTER, $enemy, $monsterOption),
        generateMapObject(MapObjectEnum::OBSTACLE, $obstacle, $obstacleOption),
        generateMapObject(MapObjectEnum::TREASURE, $treasure, $treasureOption),
    ];
}

function generateMapObject(MapObjectEnum $type, int $number, MapOption $option): array
{
    return [
        'type' => $type,
        'number' => $number,
        'option' => $option,
    ];
}
