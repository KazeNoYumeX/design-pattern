<?php

namespace C3M2H1;

use C3M2H1\Commands\Command;
use C3M2H1\Enums\ButtonEnum;

class Keyboard
{
    protected array $keys = [];

    public function __construct(
        private readonly MainController $controller
    ) {
        $this->reset();
    }

    public function reset(): void
    {
        // Set the keys to the buttons
        $buttons = ButtonEnum::cases();
        $first = array_shift($buttons);

        // Fill the keys with the buttons
        $keys = array_fill($first->value, count($buttons), null);
        $this->setKeys($keys);
    }

    public function setKeys(array $keys): void
    {
        $this->keys = $keys;
    }

    public function press(string $key): void
    {
        $key = ButtonEnum::toUpperAscii($key);
        $command = $this->keys[$key] ?? null;

        if (! $command) {
            echo 'No command found for key: '.$key.PHP_EOL;

            return;
        }

        $this->controller->executed($command);
    }

    public function bind(int $key, Command $command): void
    {
        if (array_key_exists($key, $this->keys)) {
            $this->keys[$key] = $command;
        }
    }
}
