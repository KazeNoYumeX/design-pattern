<?php

namespace C3M2H1;

use C3M2H1\Commands\Command;
use C3M2H1\Enums\ButtonEnum;
use C3M2H1\Traits\StackCommandTrait;

class MainController
{
    use StackCommandTrait;

    public Keyboard $keyboard;

    public function __construct()
    {
        $this->initStack();

        $keyboard = new Keyboard($this);
        $this->setkeyboard($keyboard);
    }

    public function bind(string $key, string $command, mixed $receiver = null): void
    {
        $command = Command::transform($command, $receiver);

        if (! $command) {
            echo 'Invalid command'.PHP_EOL;

            return;
        }

        $key = ButtonEnum::toUpperAscii($key);
        $keyboard = $this->getKeyboard();
        $keyboard->bind($key, $command);
    }

    public function executed(Command $command): void
    {
        $this->executedCommand($command);
    }

    public function setKeyboard(Keyboard $keyboard): void
    {
        $this->keyboard = $keyboard;
    }

    public function getKeyboard(): Keyboard
    {
        return $this->keyboard;
    }
}
