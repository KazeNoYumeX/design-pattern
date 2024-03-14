<?php

namespace C3M2H1\Commands;

use C3M2H1\Devices\Telecom;

/**
 * @property Telecom $receiver
 */
class TelecomDisconnectCommand extends Command
{
    public function execute(): void
    {
        $this->receiver->disconnect();
    }

    public function undo(): void
    {
        $this->receiver->connect();
    }
}
