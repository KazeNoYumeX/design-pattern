<?php

namespace CardGameFramework\Players;

use CardGameFramework\Cards\Card;
use CardGameFramework\Cards\UnoCard;
use CardGameFramework\Field;

class UnoPlayer extends Player
{
    public function takeTurn(): void
    {
        $game = $this->getGame();
        $field = $game->getField();

        // If this game has field do action
        if ($field instanceof Field) {
            /** @var UnoCard $fieldCard */
            $fieldCard = $field->getCard();

            // Show field card
            echo "場上的牌是 {$fieldCard->getColor()->toCardString()} {$fieldCard->getNumber()}\n";

            echo "{$this->getName()} 的手牌: ";
            $actions = $this->getHandActions();

            // If no actions, draw a card and skip turn
            if (empty($actions)) {
                echo "沒有可以出的牌, 請抽牌\n";
                $deck = $game->getDeck();
                $this->drawCard($deck);

                return;
            }

            echo '請選擇要出的牌: ';
            foreach ($actions as $index => $action) {
                echo "[$index] $action ";
            }
            echo "\n";

            $targetCard = $this->takeAction($actions);
            if (empty($card = $this->hand->cards[$targetCard])) {
                echo "輸入錯誤, 請重新輸入\n";
                $this->takeTurn();
            }

            // Add filed card to field cards
            $field->setCards(array_merge($field->getCards(), [$fieldCard]));

            // Set card to field
            $field->setCard($card);

            // Show card
            $this->showCard($card);
        }
    }

    public function getHandActions(): array
    {
        $actions = [];
        $game = $this->getGame();
        $field = $game->getField();

        if ($field instanceof Field) {
            /** @var UnoCard $fieldCard */
            $fieldCard = $field->getCard();

            foreach ($this->getHand() as $index => $card) {
                /** @var UnoCard $card */
                echo "[$index] {$card->getColor()->toCardString()} {$card->getNumber()} ";

                // If card can be played, add to actions
                if ($fieldCard->compare($card)) {
                    $actions[$index] = "{$card->getColor()->toCardString()} {$card->getNumber()}";
                }
            }
        }

        echo "\n";

        return $actions;
    }
}
