<?php

namespace C2M2H1\ActionStrategies;

class HumanActionStrategy implements ActionStrategy
{
    public function takeAction(array $actions): int
    {
        $action = trim(fgets(STDIN));

        if (! array_key_exists($action, $actions)) {
            echo "輸入錯誤, 請重新輸入\n";
            $this->takeAction($actions);
        }

        return $action;
    }

    public function generateName(): string
    {
        $name = fgets(STDIN);

        return trim($name);
    }
}
