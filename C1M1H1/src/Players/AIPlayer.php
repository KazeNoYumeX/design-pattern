<?php

namespace C1M1H1\Players;

use Faker\Factory;
use C1M1H1\ExchangeHands;

class AIPlayer extends Player
{
    public function chooseAction(): void
    {
        $players = $this->showdown->getPlayers();

        // If there are more than one player and exchange permission then choose action
        if (count($players) > 1 && $this->exchangePermission) {
            // Randomly choose action
            if (rand(0, 1)) {
                // exchange card and can't exchange myself
                /** @var HumanPlayer|self $player */
                $num = array_rand($players);
                $player = $players[$num];

                while ($player->getName() !== $this->getName()) {
                    $num = array_rand($players);
                    $player = $players[$num];
                }

                $exchangeHand = new ExchangeHands($this, $player);
                $this->showdown->addExchangeHands($exchangeHand);
                $this->setExchangePermission(false);
            }
        }

        $targetPlayer = $this->checkChangeHands();
        $targetCard = array_rand($targetPlayer->getHand());
        $card = $targetPlayer->hand->cards[$targetCard];
        $this->showCard($card);

        // Remove card from hand
        unset($targetPlayer->hand->cards[$targetCard]);
        $targetPlayer->hand->cards = array_values($this->hand->cards);
    }

    public function nameHimself(): void
    {
        $faker = Factory::create();
        $this->setName($faker->lastName);
    }
}
