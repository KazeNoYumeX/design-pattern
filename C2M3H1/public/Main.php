<?php

declare(strict_types=1);

use C2M3H1\CollisionHandlers\HeroFireCollisionHandler;
use C2M3H1\CollisionHandlers\HeroWaterCollisionHandler;
use C2M3H1\CollisionHandlers\SelfCollisionHandler;
use C2M3H1\CollisionHandlers\WaterFireCollisionHandler;
use C2M3H1\Coordinate;
use C2M3H1\Sprites\FireSprite;
use C2M3H1\Sprites\HeroSprite;
use C2M3H1\Sprites\Sprite;
use C2M3H1\Sprites\WaterSprite;
use C2M3H1\World;

require_once dirname(__DIR__).'/vendor/autoload.php';

function initCoordinates(int $num = 30): array
{
    $coordinates = [];

    for ($i = 0; $i < $num; $i++) {
        $coordinates[] = new Coordinate($i);
    }

    return $coordinates;
}

function initSprites(array $coordinates, int $num = 10): void
{
    for ($i = 0; $i < $num; $i++) {
        $coordinate = randomCoordinate($coordinates);
        $sprites[] = generateSprite($coordinate);
        $coordinate->setObject($sprites[$i]);
    }
}

function generateSprite($coordinate): Sprite
{
    return match (rand(0, 2)) {
        0 => new HeroSprite($coordinate),
        1 => new FireSprite($coordinate),
        2 => new WaterSprite($coordinate),
    };
}

function randomCoordinate(array $coordinates): Coordinate
{
    /** @var Coordinate $coordinate */
    $coordinate = $coordinates[array_rand($coordinates)];

    if ($coordinate->getObject() !== null) {
        return randomCoordinate($coordinates);
    }

    return $coordinate;
}

// Initialize the world with coordinates and sprites
$coordinates = initCoordinates();
initSprites($coordinates);

$handlers = new SelfCollisionHandler(new WaterFireCollisionHandler(new HeroFireCollisionHandler(new HeroWaterCollisionHandler(null))));

$world = new World($coordinates, $handlers);

echo "\nInitial ";
$world->showMap();

// Move the sprite 10 times, which can be modified to an infinite loop if needed
for ($i = 0; $i < 10; $i++) {
    echo "\nRound $i\n";

    $max = count($coordinates) - 1;
    $from = rand(0, $max);
    $to = rand(0, $max);
    echo "Moving sprite from $from to $to\n";

    try {
        $world->moveSprite($from, $to);

        // Show the world after moving the sprite
        $world->showMap();
    } catch (Exception $e) {
        echo "{$e->getMessage()}\n";
    }
}

// Show the world after moving the sprite
echo "\nFinal \n";
$world->showMap();
