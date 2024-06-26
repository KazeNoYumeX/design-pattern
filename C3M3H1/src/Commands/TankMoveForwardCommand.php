<?php

namespace C3M3H1\Commands;

use C3M3H1\Devices\Tank;

/**
 * @property Tank $receiver
 */
class TankMoveForwardCommand extends Command
{
    public function execute(): void
    {
        $this->receiver->moveForward();
    }

    public function undo(): void
    {
        $this->receiver->moveBackward();
    }
}
