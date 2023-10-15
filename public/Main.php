<?php

declare(strict_types=1);

use App\Deck;
use App\Showdown;

require_once dirname(__DIR__).'/vendor/autoload.php';

function validateInput($input): bool
{
    return $input < 0 || $input > 4;
}

function inputPlayers(string $msg): int
{
    echo $msg;
    $num = fgets(STDIN);
    $num = trim($num);
    if (validateInput($num)) {
        echo "輸入錯誤, 請重新輸入\n";
        inputPlayers($msg);
    }

    return (int) $num;
}

function initGame(): array
{
    $numHumanPlayers = inputPlayers('請輸入玩家人數 [0-4]：');
    $numAIPlayers = inputPlayers('請輸入電腦人數 [0-4]：');
    $totalPlayers = $numHumanPlayers + $numAIPlayers;
    if ($totalPlayers > 4 || $totalPlayers < 2) {
        echo "總人數不得超過 4 人, 且不得少於 2 人, 請重新輸入\n";

        return initGame();
    }

    return [$numHumanPlayers, $numAIPlayers];
}

[$numHumanPlayers, $numAIPlayers] = initGame();

$game = new Showdown(new Deck());

$game->startGame($numHumanPlayers, $numAIPlayers);
