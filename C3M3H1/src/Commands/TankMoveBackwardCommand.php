<?php

namespace C3M3H1\Commands;

use C3M3H1\Devices\Tank;

/**
 * @property Tank $receiver
 */
class TankMoveBackwardCommand extends Command
{
    public function execute(): void
    {
        $this->receiver->moveBackward();
    }

    public function undo(): void
    {
        $this->receiver->moveForward();
    }
}
