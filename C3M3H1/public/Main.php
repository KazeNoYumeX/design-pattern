<?php

declare(strict_types=1);

use C3M3H1\Commands\TankMoveBackwardCommand;
use C3M3H1\Commands\TankMoveForwardCommand;
use C3M3H1\Commands\TelecomConnectCommand;
use C3M3H1\Commands\TelecomDisconnectCommand;
use C3M3H1\Devices\Tank;
use C3M3H1\Devices\Telecom;
use C3M3H1\Game;
use C3M3H1\Map;

require_once dirname(__DIR__).'/vendor/autoload.php';

$map = new Map(5, 5);
$game = new Game($map);
$game->showMap();

$game->init();

//var_dump($game);

//// Bind the command to the key
//$game->bind('a', 'TankMoveForwardCommand', $tank);
//$game->bind('B', 'TankMoveBackwardCommand', $tank);
//$game->bind('c', 'TelecomConnectCommand', $telecom);
//$game->bind('D', 'TelecomDisconnectCommand', $telecom);
//
//
//$tank = new Tank();
//$telecom = new Telecom();
//// Press the key
//$game->map->press('a');
//$game->map->press('b');
//$game->map->press('c');
//$game->map->press('d');
//
//// Bind the reset command
//$game->bind('r', 'KeyboardResetCommand', $game);
//
//// Press the reset key
//$game->map->press('r');
//
//// Try to press the key again
//$game->map->press('a');
//$game->map->press('b');
//
//// Undo the last command
//$game->undo();
//
//// Try to press the key again
//$game->map->press('A');
//$game->map->press('B');
//
//// Undo and redo the last command
//$game->undo();
//$game->redo();
//
//// Set the macro command
//$commands = [
//    new TankMoveForwardCommand($tank),
//    new TankMoveBackwardCommand($tank),
//    new TelecomConnectCommand($telecom),
//    new TelecomDisconnectCommand($telecom),
//];
//
//$game->bind('x', 'MacroCommand', $commands);
//
//// Press the macro key
//$game->map->press('x');
//
//// Undo and redo the macro command
//$game->undo();
//$game->redo();
//function initMapObjects(array $coordinates, int $num = 10): void
//{
//    for ($i = 0; $i < $num; $i++) {
//        $coordinate = randomCoordinate($coordinates);
//        $MapObjects[] = generateSprite($coordinate);
//        $coordinate->setObject($MapObjects[$i]);
//    }
//}
//
//function generateSprite($coordinate): Sprite
//{
//    return match (rand(0, 2)) {
//        0 => new HeroSprite($coordinate),
//        1 => new FireSprite($coordinate),
//        2 => new WaterSprite($coordinate),
//    };
//}
//
//function randomCoordinate(array $coordinates): Coordinate
//{
//    /** @var Coordinate $coordinate */
//    $coordinate = $coordinates[array_rand($coordinates)];
//
//    if ($coordinate->getObject() !== null) {
//        return randomCoordinate($coordinates);
//    }
//
//    return $coordinate;
//}
//
//// Initialize the world with coordinates and Role
//$coordinates = initCoordinates();
//initMapObjects($coordinates);
//
//$handlers = new SelfCollisionHandler(new WaterFireCollisionHandler(new HeroFireCollisionHandler(new HeroWaterCollisionHandler(null))));
//
//$world = new World($coordinates, $handlers);
//
//echo "\nInitial ";
//$world->showMap();
//
//// Move the sprite 10 times, which can be modified to an infinite loop if needed
//for ($i = 0; $i < 10; $i++) {
//    echo "\nRound $i\n";
//
//    $max = count($coordinates) - 1;
//    $from = rand(0, $max);
//    $to = rand(0, $max);
//    echo "Moving sprite from $from to $to\n";
//
//    try {
//        $world->moveSprite($from, $to);
//
//        // Show the world after moving the sprite
//        $world->showMap();
//    } catch (Exception $e) {
//        echo "{$e->getMessage()}\n";
//    }
//}
//
//// Show the world after moving the sprite
//echo "\nFinal \n";
//$world->showMap();
