<?php

namespace C3M2H1\Commands;

abstract class Command implements CommandInterface
{
    public function __construct(
        protected mixed $receiver
    ) {
    }

    abstract public function execute(): void;

    abstract public function undo(): void;

    public static function transform(string $command, mixed $receiver): ?Command
    {
        $command = "C3M2H1\Commands\\$command";

        if (! class_exists($command)) {
            return null;
        }

        $command = new $command($receiver);

        return $command instanceof Command ? $command : null;
    }
}
