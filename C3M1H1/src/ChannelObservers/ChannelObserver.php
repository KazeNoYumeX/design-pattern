<?php

namespace C3M1H1\ChannelObservers;

interface ChannelObserver
{
    public function update(): void;

    public function threshold(): bool;
}
