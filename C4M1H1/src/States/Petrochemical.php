<?php

namespace C3MB\States;

class Petrochemical extends State
{
    public function __construct(
        protected int $duration = 3,
    ) {
        parent::__construct('石化', $duration);
    }

    public function onTakeAction(array $actions): array
    {
        return [];
    }
}
