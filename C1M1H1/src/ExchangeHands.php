<?php

namespace C1M1H1;

use C1M1H1\Players\Player;

class ExchangeHands
{
    private int $duration;

    private Player $trader;

    private Player $counterparty;

    public function __construct(Player $trader, Player $counterparty)
    {
        $this->trader = $trader;
        $this->counterparty = $counterparty;
        $this->duration = 3;
    }

    public function countdown(): void
    {
        $this->duration--;
    }

    public function getTrader(): Player
    {
        return $this->trader;
    }

    public function getCounterparty(): Player
    {
        return $this->counterparty;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }
}
