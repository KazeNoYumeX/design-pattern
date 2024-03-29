<?php

namespace C2M2H1\ActionStrategies;

use Faker\Factory;

class AIActionStrategy implements ActionStrategy
{
    public function takeAction(array $actions): int
    {
        return array_rand($actions);
    }

    public function generateName(): string
    {
        $faker = Factory::create();

        return $faker->name;
    }
}
