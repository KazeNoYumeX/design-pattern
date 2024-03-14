<?php

namespace C3M2H1\ChannelObservers;

use C3M2H1\Devices\Telecom;

readonly class MoveForwardCommand implements Command
{
    public function __construct(
        private Telecom $subscriber
    ) {
    }

    public function execute(): void
    {
        // If the video is less than 60 seconds long, unsubscribe the channel
    }
}
