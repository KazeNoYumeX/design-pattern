<?php

declare(strict_types=1);

use C3M2H1\Commands\TankMoveBackwardCommand;
use C3M2H1\Commands\TankMoveForwardCommand;
use C3M2H1\Commands\TelecomConnectCommand;
use C3M2H1\Commands\TelecomDisconnectCommand;
use C3M2H1\Devices\Tank;
use C3M2H1\Devices\Telecom;
use C3M2H1\MainController;

require_once dirname(__DIR__).'/vendor/autoload.php';

$tank = new Tank();
$telecom = new Telecom();
$mainController = new MainController();

// Bind the command to the key
$mainController->bind('a', 'TankMoveForwardCommand', $tank);
$mainController->bind('B', 'TankMoveBackwardCommand', $tank);
$mainController->bind('c', 'TelecomConnectCommand', $telecom);
$mainController->bind('D', 'TelecomDisconnectCommand', $telecom);

// Press the key
$mainController->keyboard->press('a');
$mainController->keyboard->press('b');
$mainController->keyboard->press('c');
$mainController->keyboard->press('d');

// Bind the reset command
$mainController->bind('r', 'KeyboardResetCommand', $mainController);

// Press the reset key
$mainController->keyboard->press('r');

// Try to press the key again
$mainController->keyboard->press('a');
$mainController->keyboard->press('b');

// Undo the last command
$mainController->undo();

// Try to press the key again
$mainController->keyboard->press('A');
$mainController->keyboard->press('B');

// Undo and redo the last command
$mainController->undo();
$mainController->redo();

// Set the macro command
$commands = [
    new TankMoveForwardCommand($tank),
    new TankMoveBackwardCommand($tank),
    new TelecomConnectCommand($telecom),
    new TelecomDisconnectCommand($telecom),
];

$mainController->bind('x', 'MacroCommand', $commands);

// Press the macro key
$mainController->keyboard->press('x');

// Undo and redo the macro command
$mainController->undo();
$mainController->redo();
