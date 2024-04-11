<?php

namespace C3M3H1\Devices;

class Telecom extends Device
{
    public function connect(): void
    {
        echo 'The telecom has been turned on'.PHP_EOL;
    }

    public function disconnect(): void
    {
        echo 'The telecom has been turned off'.PHP_EOL;
    }
}
