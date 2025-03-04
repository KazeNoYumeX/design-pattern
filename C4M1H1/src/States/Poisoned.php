<?php

namespace C3MB\States;

class Poisoned extends State
{
    public function __construct(
        protected int $duration = 3,
    ) {
        parent::__construct('中毒', $duration);
    }

    public function onTakeAction(array $actions): array
    {
        $this->unit?->damage(15);

        return parent::onTakeAction($actions);
    }
}
