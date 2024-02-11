<?php

namespace C2M2H1\Players;

use C2M2H1\Cards\Card;
use C2M2H1\Cards\PokerCard;

class PokerPlayer extends Player
{
    protected Card $showedCard;

    private int $point = 0;

    public function gainPoint(): void
    {
        $point = $this->getPoint();
        $this->setPoint($point + 1);
    }

    public function getPoint(): int
    {
        return $this->point;
    }

    public function setPoint(int $point): void
    {
        $this->point = $point;
    }

    public function takeTurn(): void
    {
        echo "{$this->getName()} 請選擇要出的手牌: ";
        $actions = $this->getHandActions();
        $targetCard = $this->takeAction($actions);

        if (empty($this->hand->cards[$targetCard])) {
            echo "輸入錯誤, 請重新輸入\n";
            $this->takeTurn();
        } else {
            $card = $this->hand->cards[$targetCard];

            // Show card and
            $this->showCard($card);
            $this->setShowedCard($card);
        }
    }

    public function getHandActions(): array
    {
        $actions = [];

        foreach ($this->getHand() as $index => $card) {
            /** @var PokerCard $card */
            echo "[$index] {$card->getSuit()->toCardString()} {$card->getRank()->toCardString()} ";
            $actions[] = "{$card->getSuit()->toCardString()} {$card->getRank()->toCardString()}";
        }
        echo "\n";

        return $actions;
    }

    public function getShowedCard(): Card
    {
        return $this->showedCard;
    }

    public function setShowedCard(Card $card): void
    {
        $this->showedCard = $card;
    }
}
