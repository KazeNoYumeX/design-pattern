<?php

namespace C3M2H1\Commands;

class MacroCommand extends Command
{
    private array $commands;

    public function __construct(array $commands)
    {
        parent::__construct(null);
        $this->commands = $commands;
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
        $this->command($this->commands, 'execute');
    }

    public function undo(): void
    {
        $commands = array_reverse($this->commands);
        $this->command($commands, 'undo');
    }
}
