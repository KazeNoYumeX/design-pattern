<?php

namespace App\Strategies;

use App\Individual;
use App\Interfaces\Strategy;

class DistanceBasedStrategy implements Strategy
{
    private readonly string $name;

    public function __construct()
    {
        $this->name = '距離先決 (Distance-Based)';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function sortConditions(Individual $individual, array $conditions): array
    {
        $coordinate = $individual->getCoordinate();
        [$x, $y] = $coordinate->getPosition();

        usort($conditions, function ($left, $right) use ($x, $y) {
            $conditionLift = $left->getCoordinate();
            [$leftX, $leftY] = $conditionLift->getPosition();

            $conditionRight = $right->getCoordinate();
            [$rightX, $rightY] = $conditionRight->getPosition();

            $distanceX = sqrt(pow($x - $leftX, 2) + pow($y - $leftY, 2));
            $distanceY = sqrt(pow($x - $rightX, 2) + pow($y - $rightY, 2));

            // If the distance is the same, sort by id
            if ($distanceX === $distanceY) {
                return $left->getId() <=> $right->getId();
            }

            return $distanceX <=> $distanceY;
        });

        return $conditions;
    }
}
