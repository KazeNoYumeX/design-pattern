<?php

declare(strict_types=1);

use C2MB\ActionStrategies\AIActionStrategy;
use C2MB\ActionStrategies\HumanActionStrategy;
use C2MB\Cards\PokerCard;
use C2MB\Deck;
use C2MB\Games\BigTwo;
use C2MB\Players\PokerPlayer;
use C2MB\Turns\PokerTurn;

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
    if ($totalPlayers > 4) {
        echo "總人數不得超過 4 人, 請重新輸入\n";

        return initGame();
    }

    if ($totalPlayers < 4) {
        echo "總人數不得少於 4 人, 請重新輸入\n";

        return initGame();
    }

    return [$numHumanPlayers, $numAIPlayers];
}

//function addPlayers(int $player, int $ai): void
//{
//    for ($i = 0; $i < $player; $i++) {
//        echo '請輸入玩家'.$i + 1 .'名稱：';
//        $player = new PokerPlayer($this, new HumanActionStrategy());
//        $player->nameHimself();
//        $this->addPlayer($player);
//    }
//
//    for ($i = 0; $i < $ai; $i++) {
//        $player = new PokerPlayer($this, new AIActionStrategy());
//        $player->nameHimself();
//        $this->addPlayer($player);
//    }
//}

[$numHumanPlayers, $numAIPlayers] = initGame();

$cards = PokerCard::createCards();
$showdown = new BigTwo(new Deck($cards), new PokerTurn());
$showdown->init($numHumanPlayers, $numAIPlayers);
