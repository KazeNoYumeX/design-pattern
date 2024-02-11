<?php

namespace C1M1H1\Players;

use C1M1H1\Card;
use C1M1H1\Deck;
use C1M1H1\ExchangeHands;
use C1M1H1\Hand;
use C1M1H1\Showdown;

abstract class Player
{
    protected string $name;

    protected Hand $hand;

    protected int $point = 0;

    protected bool $exchangePermission = true;

    protected Card $showedCard;

    protected Showdown $showdown;

    public function __construct(Showdown $showdown)
    {
        $this->hand = new Hand();
        $this->showdown = $showdown;
    }

    abstract public function chooseAction(): void;

    abstract public function nameHimself(): void;

    public function getPoint(): int
    {
        return $this->point;
    }

    public function gainPoint(): void
    {
        $this->point++;
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
        return $this->hand->cards;
    }

    public function setHand(Card $card): void
    {
        $this->hand->cards[] = $card;
    }

    public function drawCard(Deck $deck): void
    {
        $card = $deck->draw();
        $this->setHand($card);
    }

    public function getShowedCard(): Card
    {
        return $this->showedCard;
    }

    public function showCard(Card $card): void
    {
        $this->showedCard = $card;
    }

    public function setExchangePermission(bool $bool): void
    {
        $this->exchangePermission = $bool;
    }

    public function checkChangeHands(): Player
    {
        $targetPlayer = $this;
        $exchangeHands = $this->showdown->getExchangeHands();
        if (count($exchangeHands) !== 0) {
            foreach ($exchangeHands as $exchangeHand) {
                /** @var ExchangeHands $exchangeHand */
                if ($exchangeHand->getTrader() === $targetPlayer) {
                    $targetPlayer = $exchangeHand->getCounterparty();
                } elseif ($exchangeHand->getCounterparty() === $targetPlayer) {
                    $targetPlayer = $exchangeHand->getTrader();
                }
            }
        }

        return $targetPlayer;
    }
}
