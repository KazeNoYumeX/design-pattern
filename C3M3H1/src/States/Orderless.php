<?php

namespace C3M3H1\States;

class Orderless extends State
{
    public function __construct()
    {
        parent::__construct('混亂', 3);
    }

    public function onGetAction(array $actions): array
    {
        return array_filter($actions, fn ($action) => $action !== 'move');
    }

    public function onMove(array $range): array
    {
        [$x, $y] = $range;

        return rand(0, 1) ? [$x, 0] : [0, $y];
    }
}
