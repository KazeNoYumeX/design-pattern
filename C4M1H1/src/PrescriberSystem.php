<?php

namespace C4M1H1;

use SplQueue;

class PrescriberSystem
{
    public function __construct(
        protected SplQueue $queue = new SplQueue,
    ) {}
}
