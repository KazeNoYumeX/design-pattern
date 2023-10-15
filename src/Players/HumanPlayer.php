<?php

namespace App\Players;

use App\Card;

class HumanPlayer extends Player
{
    public function chooseAction(): void
    {
        echo "{$this->getName()} 的手牌: ";
        foreach ($this->getHand() as $index => $card) {
            /** @var Card $card */
            echo "[$index] {$card->getSuit()->toCardString()}{$card->getRank()->toCardString()} ";
        }
        echo "\n請選擇要出的牌: ";

        $target = trim(fgets(STDIN));

        if (empty($this->hand[$target])) {
            echo "輸入錯誤, 請重新輸入\n";
            $this->chooseAction();
        } else {
            // Show card and
            $card = $this->hand[$target];
            $this->showCard($card);

            // Remove card from hand
            unset($this->hand[$target]);
            $this->hand = array_values($this->hand);
        }
    }
}
