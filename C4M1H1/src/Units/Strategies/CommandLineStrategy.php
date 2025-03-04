<?php

namespace C3MB\Units\Strategies;

use C3MB\Skills\Action;

class CommandLineStrategy implements Strategy
{
    public function chooseAction(array $options): int
    {
        echo '選擇行動: ';

        /** @var Action $option */
        foreach ($options as $key => $option) {
            echo "($key) {$option->getName()} ";
        }

        $choose = trim(fgets(STDIN));

        if (! array_key_exists($choose, $options)) {
            return $this->chooseAction($options);
        }

        return $choose;
    }

    public function chooseTarget(array $options, int $num = 1): array
    {
        echo "選擇 $num 位目標: ";
        foreach ($options as $key => $option) {
            echo "($key) {$option->getName()} ";
        }

        $choose = trim(fgets(STDIN));
        $choose = explode(' ', $choose);

        $targets = array_map(fn ($key) => $options[$key] ?? null, $choose);

        // If targets contain null, reselect
        if (in_array(null, $targets, true)) {
            return $this->chooseTarget($options, $num);
        }

        return $targets;
    }
}
