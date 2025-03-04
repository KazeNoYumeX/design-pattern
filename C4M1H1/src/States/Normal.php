<?php

namespace C4M1H1\States;

use C4M1H1\Prescription;

class Normal extends Prescription
{
    public function __construct()
    {
        parent::__construct('正常');
    }

    public function exitState(): void {}

    public function onEndAction(): void {}
}
