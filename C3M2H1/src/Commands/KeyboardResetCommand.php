<?php

namespace C3M2H1\Commands;

use C3M2H1\MainController;
use SplStack;

/**
 * @property MainController $receiver
 */
class KeyboardResetCommand extends Command
{
    private SplStack $executed;

    public function __construct(MainController $receiver)
    {
        parent::__construct($receiver);
        $this->executed = new SplStack();
    }

    public function execute(): void
    {
        $keyboard = $this->receiver->getKeyboard();
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
        $this->receiver->setKeyboard($keyboard);

        echo 'Undo the keyboard reset.'.PHP_EOL;
    }
}
