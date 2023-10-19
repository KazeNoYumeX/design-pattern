<?php

namespace App\Players;

use Faker\Factory;

class AIPlayer extends Player
{
    public function chooseAction(): void
    {
        // Randomly choose a card
        $target = array_rand($this->getHand());
        $card = $this->hand->cards[$target];
        $this->showCard($card);

        // Remove card from hand
        unset($this->hand->cards[$target]);
        $this->hand->cards = array_values($this->hand->cards);
    }

    public function nameHimself(): void
    {
        $faker = Factory::create();
        $this->setName($faker->lastName);
    }
}
