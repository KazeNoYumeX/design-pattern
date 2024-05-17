<?php

namespace C3M2H1\Commands;

class MacroCommand extends Command
{
    public function __construct(array $commands)
    {
        parent::__construct($commands);
    }

    private function command(array $commands, string $method): void
    {
        foreach ($commands as $command) {
            /** @var Command $command */
            $command->$method();
        }

        echo ucfirst($method).' the macro command.'.PHP_EOL;
    }

    public function execute(): void
    {
        $this->command($this->receiver, 'execute');
    }

    public function undo(): void
    {
        $commands = array_reverse($this->receiver);
        $this->command($commands, 'undo');
    }
}
