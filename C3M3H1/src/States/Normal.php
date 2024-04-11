<?php

namespace C3M3H1\States;

class Normal extends State
{
    public function __construct()
    {
        parent::__construct('正常');
    }

    public function exitState(): void {}

    public function onEndAction(): void {}
}
