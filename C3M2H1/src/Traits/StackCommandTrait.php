<?php

namespace C3M2H1\Traits;

use SplStack;

trait StackCommandTrait
{
    private SplStack $executed;

    private SplStack $reversed;

    protected function initStack(): void
    {
        $this->executed = new SplStack();
        $this->reversed = new SplStack();
    }

    private function executeStackCommand(SplStack $stack1, SplStack $stack2, string $method): void
    {
        // Check if the stack is empty
        if ($stack1->isEmpty()) {
            return;
        }

        // Execute the stack command
        echo ucfirst($method).': '.PHP_EOL;
        $command = $stack1->pop();
        $command->$method();

        // Store the command in the other stack
        $stack2->push($command);
    }

    public function undo(): void
    {
        $this->executeStackCommand($this->executed, $this->reversed, 'undo');
    }

    public function redo(): void
    {
        $this->executeStackCommand($this->reversed, $this->executed, 'execute');
    }

    public function executedCommand($command): void
    {
        // Execute the command
        echo 'Execute: '.PHP_EOL;
        $command->execute();

        // Store the command in the executed stack
        $this->executed->push($command);
    }
}
