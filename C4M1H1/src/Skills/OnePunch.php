<?php

namespace C3MB\Skills;

use C3MB\Skills\Handler\EffectHandler;
use C3MB\Skills\Strategies\EnemyPickStrategy;
use C3MB\Units\Unit;

class OnePunch extends Action implements Skill
{
    public function __construct(
        protected readonly array $handlers = []
    ) {
        parent::__construct('一拳攻擊', new EnemyPickStrategy($this), 180);
    }

    public function execute(): void
    {
        // Spend MP
        parent::execute();

        // Get the handlers
        $handler = $this->getHandlers();
        if (! $handler) {
            return;
        }

        // Handle the effect
        $effect = fn (Unit $target) => $handler->handle($target);
        $this->effectTargets($effect);
    }

    public function getHandlers(): ?EffectHandler
    {
        $handlers = array_reverse($this->handlers);
        $handler = null;

        foreach ($handlers as $handlerClass) {
            $handler = new $handlerClass($handler);
        }

        return $handler;
    }
}
