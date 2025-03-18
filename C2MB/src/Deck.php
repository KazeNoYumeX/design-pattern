<?php

namespace C2MB;

use C2MB\Cards\Card;
use C2MB\Players\Player;

class Deck
{
    private array $cards;

    public function __construct(array $cards = [])
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

    public function recycle(Field $field): void
    {
        $cards = $field->getTopPlay();

        // Recycle the field cards to the deck
        $this->cards = array_merge($this->cards, $cards);

        // Clear the field cards
        $field->setTopPlay([]);
    }
}
