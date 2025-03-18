<?php

namespace C2MB\Players;

use C2MB\BigTwo;
use C2MB\Cards\Card;
use C2MB\Cards\CardPatterns\CardPattern;
use C2MB\Deck;
use C2MB\Field;
use C2MB\Hand;

abstract class Player
{
    protected string $name;

    public function __construct(
        private readonly BigTwo $game,
        protected Hand $hand = new Hand,
    ) {}

    public function getGame(): BigTwo
    {
        return $this->game;
    }

    public function nameHimself(): void
    {
        $name = $this->generateName();
        $this->setName($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Card[]
     */
    public function getHand(): array
    {
        return $this->hand->getCards();
    }

    public function setHand(Card $card): void
    {
        $this->hand->cards[] = $card;
    }

    public function drawCard(Deck $deck): void
    {
        $card = $deck->draw();

        // If the deck is empty, check this game has field or not
        if (empty($card)) {
            $field = $this->game->getField();

            // If the field not empty, recycle the field
            if ($field instanceof Field) {
                $deck->recycle($field);
                $card = $deck->draw();
            }
        }

        // If the card is not empty, set the card to hand
        if ($card instanceof Card) {
            $this->setHand($card);
        }
    }

    public function showCard(Card $card): void
    {
        // Remove card from hand
        $target = array_search($card, $this->hand->cards);
        unset($this->hand->cards[$target]);
        $this->hand->cards = array_values($this->hand->cards);
    }

    public function takeAction(array $actions): int
    {
        return $this->strategy->takeAction($actions);
    }

    public function takeTurn(): void
    {
        // pass or take action

        // 如果出牌
        echo "{$this->getName()} 請選擇要出的手牌: ";
        $actions = $this->getHandActions();
        $targetCards = $this->takeAction($actions);

        $game = $this->getGame();
        $cardPattern = $game->validate($targetCards);

        if (! $cardPattern instanceof CardPattern){
            // 無效的牌型，請重來
        }

        // 取得 field 狀態
        $field = $game->getField();
        if (! $field->validateTopPlay($cardPattern)){
            // 無法出牌，請重來
        }

        //
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
        }
    }

    public function getHandActions(): array
    {
        $actions = [];

        foreach ($this->getHand() as $index => $card) {
            /** @var Card $card */
            echo "[$index] {$card->getSuit()->toCardString()} {$card->getRank()->toCardString()} ";
            $actions[] = "{$card->getSuit()->toCardString()} {$card->getRank()->toCardString()}";
        }
        echo "\n";

        return $actions;
    }
}
