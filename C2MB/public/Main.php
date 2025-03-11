<?php

declare(strict_types=1);

use C2MB\BigTwo;
use C2MB\Cards\Card;
use C2MB\Deck;
use C2MB\Players\AIPlayer;
use C2MB\Players\HumanPlayer;

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

function initPlayers(): array
{
    $numHumanPlayers = inputPlayers('請輸入玩家人數 [0-4]：');
    $numAIPlayers = inputPlayers('請輸入電腦人數 [0-4]：');
    $totalPlayers = $numHumanPlayers + $numAIPlayers;
    if ($totalPlayers > 4) {
        echo "總人數不得超過 4 人, 請重新輸入\n";

        return initPlayers();
    }

    if ($totalPlayers < 4) {
        echo "總人數不得少於 4 人, 請重新輸入\n";

        return initPlayers();
    }

    return [$numHumanPlayers, $numAIPlayers];
}
function initGame($cards): BigTwo
{
    $bigTwo = new BigTwo(new Deck($cards));

    [$humans, $ai] = initPlayers();

    for ($i = 0; $i < $humans; $i++) {
        echo '請輸入玩家'.$i + 1 .'名稱：';
        $player = new HumanPlayer($bigTwo);
        $player->nameHimself();
        $bigTwo->addPlayer($player);
    }

    for ($i = 0; $i < $ai; $i++) {
        $player = new AIPlayer($bigTwo);
        $player->nameHimself();
        $bigTwo->addPlayer($player);
    }

    return $bigTwo;
}

$cards = Card::createCards();
$bigTwo = initGame($cards);

// Show the game information
$bigTwo->showInfo();

$bigTwo->start();
