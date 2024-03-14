<?php

namespace C3M2H1\Commands;

use C3M2H1\Devices\Tank;

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
