<?php

namespace C3M3H1\Commands;

use C3M3H1\Game;
use SplStack;

/**
 * @property Game $receiver
 */
class KeyboardResetCommand extends Command
{
    private SplStack $executed;

    public function __construct(Game $receiver)
    {
        parent::__construct($receiver);
        $this->executed = new SplStack();
    }

    public function execute(): void
    {
        $keyboard = $this->receiver->getMap();
        $this->executed->push(clone $keyboard);

        $keyboard->reset();
        echo 'Reset the keyboard.'.PHP_EOL;
    }

    public function undo(): void
    {
        if ($this->executed->isEmpty()) {
            return;
        }

        $keyboard = $this->executed->pop();
        $this->receiver->setMap($keyboard);

        echo 'Undo the keyboard reset.'.PHP_EOL;
    }
}
