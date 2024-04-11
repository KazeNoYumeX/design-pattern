<?php

namespace C3M3H1\States;

class Normal extends State
{
    public string $name = '正常';

    public function exitState(): void {}

    public function onEndAction(): void {}
}
