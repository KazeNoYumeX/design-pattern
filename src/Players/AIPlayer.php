<?php

namespace App\Players;

class AIPlayer extends Player
{
    public function chooseAction(): void
    {
        // Randomly choose a card
        $target = array_rand($this->getHand());
        $card = $this->hand[$target];
        $this->showCard($card);

        // Remove card from hand
        unset($this->hand[$target]);
        $this->hand = array_values($this->hand);
    }
}
