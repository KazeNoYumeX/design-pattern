<?php

namespace CardGameFramework;

use CardGameFramework\Cards\Card;
use CardGameFramework\Players\Player;

class Deck
{
    private array $cards;

    public function __construct(array $cards = [])
    {
        $this->cards = $cards;
    }

    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function draw(): ?Card
    {
        return array_pop($this->cards);
    }

    public function recycle(Field $field): void
    {
        $cards = $field->getCards();

        // Reset the field cards to deck, and shuffle
        $this->setCards(array_merge($this->cards, $cards));
        $this->shuffle();

        // Reset the field card to null
        $field->setCards([]);
    }

    public function distributeCards(array $players, int $num = 0): void
    {
        // Draw cards for each player
        for ($i = 0; $i < $num; $i++) {
            foreach ($players as $player) {
                /** @var Player $player */
                $player->drawCard($this);
            }
        }
    }
}
