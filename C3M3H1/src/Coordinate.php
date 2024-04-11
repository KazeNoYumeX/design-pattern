<?php

namespace C3M3H1;

use C3M3H1\MapObjects\MapObject;

class Coordinate
{
    public ?MapObject $object = null;

    public function __construct(
        protected Map $map,
        private readonly int $x,
        private readonly int $y,
    ) {}

    public function showSymbol(): void
    {
        $y = $this->getY();
        if ($y % 5 === 0 && $y !== 0) {
            echo ' ';
        }

        echo $this->object?->showSymbol() ?? '-';
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function swap(Coordinate $to): void
    {
        $fromObject = $this->getObject();
        $toObject = $to->getObject();

        $this->setObject($toObject);
        $to->setObject($fromObject);
    }

    public function getObject(): ?MapObject
    {
        return $this->object;
    }

    public function setObject(?MapObject $object): void
    {
        $this->object = $object;

        // Set the object to the new coordinate
        if ($object !== null) {
            $this->object->setCoordinate($this);
        }
    }

    public function removeObject(MapObject $object): void
    {
        $this->setObject(null);

        // Remove the object from the map objects
        $this->map->removeMapObject($object);
    }

    /**
     * 找鄰近座標中的特定物件
     */
    public function findNearbyCondition(int $x, int $y, int $range, callable $condition): array
    {
        $queue = [[$oriX = $this->getX(), $oriY = $this->getY()]];
        $visited = [];

        $expected = [];
        $coordinates = $this->map->getCoordinates();

        while (! empty($queue)) {
            [$currentX, $currentY] = array_shift($queue);

            // Skip if already visited
            if (isset($visited["$currentX,$currentY"])) {
                continue;
            }

            // Mark as visited
            $visited["$currentX,$currentY"] = true;

            // Get the current coordinate
            $currentCoordinate = $coordinates[$currentX][$currentY] ?? null;
            $object = $currentCoordinate?->getObject();

            if ($currentCoordinate && $condition($object) && $currentCoordinate !== $this) {
                $expected[] = $currentCoordinate;
            }

            // Add adjacent coordinates to the queue within the range
            for ($dx = -$x; $dx <= $x; $dx++) {
                for ($dy = -$y; $dy <= $y; $dy++) {
                    if ($dx === 0 && $dy === 0) {
                        continue;
                    }

                    $adjX = $currentX + $dx;
                    $adjY = $currentY + $dy;

                    if (! isset($visited["$adjX,$adjY"]) && $this->isValidCoordinate($adjX, $adjY)) {
                        if ($oriX + $x < $adjX || $oriX - $x > $adjX || $oriY + $y < $adjY || $oriY - $y > $adjY) {
                            continue;
                        }

                        $diffX = abs($oriX - $adjX);
                        $diffY = abs($oriY - $adjY);

                        if ($diffX + $diffY > $range) {
                            continue;
                        }

                        $queue[] = [$adjX, $adjY];
                    }
                }
            }
        }

        return $expected;
    }

    public function getX(): int
    {
        return $this->x;
    }

    private function isValidCoordinate(int $x, int $y): bool
    {
        $coordinates = $this->map->getCoordinates();

        return isset($coordinates[$x][$y]);
    }

    /**
     * 取得方位的指定範圍, 並檢查是否有特定物件, 當遇到特定條件後停止搜尋
     */
    public function existDirectionByCondition(int $x, int $y, callable $findCondition, callable $breakCondition): bool
    {
        $currentX = $this->getX();
        $currentY = $this->getY();
        $coordinates = $this->map->getCoordinates();

        while (true) {
            $currentX += $x;
            $currentY += $y;

            if (! $this->isValidCoordinate($currentX, $currentY)) {
                return false;
            }

            $currentCoordinate = $coordinates[$currentX][$currentY] ?? null;
            $object = $currentCoordinate?->getObject();

            if ($currentCoordinate && $findCondition($object)) {
                return true;
            }

            if ($currentCoordinate && $breakCondition($object)) {
                return false;
            }
        }
    }

    public function findDirectionByCondition(int $x, int $y, callable $condition, callable $breakCondition): array
    {
        $currentX = $this->getX();
        $currentY = $this->getY();
        $coordinates = $this->map->getCoordinates();

        $expected = [];

        while (true) {
            $currentX += $x;
            $currentY += $y;

            if (! $this->isValidCoordinate($currentX, $currentY)) {
                return $expected;
            }

            $currentCoordinate = $coordinates[$currentX][$currentY] ?? null;
            $object = $currentCoordinate?->getObject();

            if ($currentCoordinate && $condition($object) && $currentCoordinate !== $this) {
                $expected[] = $currentCoordinate;
            }

            if ($currentCoordinate && $breakCondition($object)) {
                return $expected;
            }
        }
    }

    /**
     * 找鄰近座標中的特定物件
     */
    public function existNearbyCondition(int $x, int $y, int $range, callable $condition): bool
    {
        $queue = [[$oriX = $this->getX(), $oriY = $this->getY()]];
        $visited = [];

        while (! empty($queue)) {
            [$currentX, $currentY] = array_shift($queue);

            // Skip if already visited
            if (isset($visited["$currentX,$currentY"])) {
                continue;
            }

            // Mark as visited
            $visited["$currentX,$currentY"] = true;

            // Get the current coordinate
            $currentCoordinate = $this->map->getCoordinates()[$currentX][$currentY] ?? null;
            $object = $currentCoordinate?->getObject();

            if ($currentCoordinate && $condition($object) && $currentCoordinate !== $this) {
                return true;
            }

            // Add adjacent coordinates to the queue within the range
            for ($dx = -$x; $dx <= $x; $dx++) {
                for ($dy = -$y; $dy <= $y; $dy++) {
                    if ($dx === 0 && $dy === 0) {
                        continue;
                    }

                    $adjX = $currentX + $dx;
                    $adjY = $currentY + $dy;

                    if (! isset($visited["$adjX,$adjY"]) && $this->isValidCoordinate($adjX, $adjY)) {
                        if ($oriX + $x < $adjX || $oriX - $x > $adjX || $oriY + $y < $adjY || $oriY - $y > $adjY) {
                            continue;
                        }

                        $diffX = abs($oriX - $adjX);
                        $diffY = abs($oriY - $adjY);

                        if ($diffX + $diffY > $range) {
                            continue;
                        }

                        $queue[] = [$adjX, $adjY];
                    }
                }
            }
        }

        return false;
    }

    public function getMap(): Map
    {
        return $this->map;
    }

    public function diffDirection(Coordinate $nextCoordinate): int
    {
        $dx = $nextCoordinate->getX() - $this->getX();
        $dy = $nextCoordinate->getY() - $this->getY();

        return match (true) {
            $dy === 1 => 0, // North
            $dx === 1 => 90, // East
            $dy === -1 => 180, // South
            $dx === -1 => 270, // West
            default => -1,
        };
    }
}
