<?php

namespace App\Players;

use App\Card;
use App\ExchangeHands;

class HumanPlayer extends Player
{
    public function chooseAction(): void
    {
        $players = $this->showdown->getPlayers();

        // If there are more than one player and exchange permission then choose action
        if (count($players) > 1 && $this->exchangePermission) {
            // choose action 1. 換牌 2. 出牌
            echo "{$this->getName()} 選擇行動: 1. 換牌 2. 出牌\n";
            $action = trim(fgets(STDIN));
            if ($action == 1) {
                // exchange card and set exchange permission to false
                echo '請選擇要與哪位玩家交換手牌: ';

                // echo players list and filter out current player
                foreach ($players as $index => $player) {
                    if ($player->getName() != $this->getName()) {
                        echo "[$index] {$player->getName()} ";
                    }
                }
                echo "\n";

                $target = trim(fgets(STDIN));
                var_dump($target);

                // If target is empty or target is not in players list then choose action again
                if (empty($players[$target]) || $players[$target]->getName() == $this->getName()) {
                    echo "輸入錯誤, 請重新輸入\n";
                    $this->chooseAction();

                    return;
                }

                // exchange card
                $exchangeHand = new ExchangeHands($this, $players[$target]);
                $this->showdown->addExchangeHands($exchangeHand);
                $this->setExchangePermission(false);
            } elseif ($action != 2) {
                echo "輸入錯誤, 請重新輸入\n";
                $this->chooseAction();

                return;
            }
        }

        $targetPlayer = $this->checkChangeHands();
        echo "{$targetPlayer->getName()} 的手牌: ";
        foreach ($targetPlayer->getHand() as $index => $card) {
            /** @var Card $card */
            echo "[$index] {$card->getSuit()->toCardString()}{$card->getRank()->toCardString()} ";
        }
        echo "\n請選擇要出的牌: ";

        $targetCard = trim(fgets(STDIN));

        if (empty($targetPlayer->hand->cards[$targetCard])) {
            echo "輸入錯誤, 請重新輸入\n";
            $this->chooseAction();
        } else {
            // Show card and
            $card = $targetPlayer->hand->cards[$targetCard];
            $this->showCard($card);

            // Remove card from hand
            unset($targetPlayer->hand->cards[$targetCard]);
            $targetPlayer->hand->cards = array_values($this->hand->cards);
        }
    }

    public function nameHimself(): void
    {
        $name = fgets(STDIN);
        $name = trim($name);
        $this->setName($name);
    }
}
