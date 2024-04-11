<?php

namespace C3M3H1\Commands;

interface CommandInterface
{
    public function execute(): void;

    public function undo(): void;
}
