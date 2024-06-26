<?php

namespace C3M3H1;

use C3M3H1\Cards\Card;

class Field
{
    private ?Card $card = null;

    private array $cards = [];

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(Card $card): void
    {
        $this->card = $card;
    }

    public function getCards(): array
    {
        return $this->cards;
    }

    public function setCards(array $cards): void
    {
        $this->cards = $cards;
    }
}
