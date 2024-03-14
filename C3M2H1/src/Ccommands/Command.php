<?php

namespace C3M2H1\ChannelObservers;

interface Command
{
    public function execute(): void;
}
