<?php

namespace C3M3H1\Commands;

use C3M3H1\Devices\Telecom;

/**
 * @property Telecom $receiver
 */
class TelecomConnectCommand extends Command
{
    public function execute(): void
    {
        $this->receiver->connect();
    }

    public function undo(): void
    {
        $this->receiver->disconnect();
    }
}
