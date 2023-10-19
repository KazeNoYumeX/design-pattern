<?php

namespace App\Players;

use App\Card;

class HumanPlayer extends Player
{
    public function chooseAction(): void
    {
        $players = $this->showdown->getPlayers();

        // If there are more than one player and exchange permission then choose action
        if (count($players) > 1 && $this->exchangePermission) {
            // 選擇行動
            echo "{$this->getName()} 選擇行動: 1. 換牌 2. 出牌\n";
            $action = trim(fgets(STDIN));
            if ($action == 1) {
                // 換牌
                echo "{$this->getName()} 選擇換牌\n";
                //                $this->exchangeCard();
            } else {
                if ($action != 2) {
                    echo "輸入錯誤, 請重新輸入\n";
                    $this->chooseAction();

                    return;
                }
            }

            // 1. 換牌 2. 出牌
            // 選擇 2 跳出 if 執行後面的程式碼

        }

        echo "{$this->getName()} 的手牌: ";
        foreach ($this->getHand() as $index => $card) {
            /** @var Card $card */
            echo "[$index] {$card->getSuit()->toCardString()}{$card->getRank()->toCardString()} ";
        }
        echo "\n請選擇要出的牌: ";

        $target = trim(fgets(STDIN));

        if (empty($this->hand->cards[$target])) {
            echo "輸入錯誤, 請重新輸入\n";
            $this->chooseAction();
        } else {
            // Show card and
            $card = $this->hand->cards[$target];
            $this->showCard($card);

            // Remove card from hand
            unset($this->hand->cards[$target]);
            $this->hand->cards = array_values($this->hand->cards);
        }
    }

    public function nameHimself(): void
    {
        $name = fgets(STDIN);
        $name = trim($name);
        $this->setName($name);
    }
}
