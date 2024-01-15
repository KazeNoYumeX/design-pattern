<?php

namespace CardGameFramework\Players;

use CardGameFramework\ActionStrategies\ActionStrategy;
use CardGameFramework\Cards\Card;
use CardGameFramework\Deck;
use CardGameFramework\Field;
use CardGameFramework\Games\Game;
use CardGameFramework\Hand;

abstract class Player
{
    protected string $name;

    protected Hand $hand;

    public function __construct(
        private readonly Game $game,
        protected readonly ActionStrategy $strategy
    ) {
        $this->hand = new Hand();
    }

    abstract public function takeTurn(): void;

    abstract public function getHandActions(): array;

    public function getGame(): Game
    {
        return $this->game;
    }

    public function nameHimself(): void
    {
        $name = $this->strategy->generateName();
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
}
