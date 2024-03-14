<?php

namespace C3M2H1\Devices;

class Tank extends Device
{
    private function move(string $direction): void
    {
        echo "The tank has moved $direction\n";
    }

    public function moveForward(): void
    {
        $this->move('forward');
    }

    public function moveBackward(): void
    {
        $this->move('backward');
    }
}
