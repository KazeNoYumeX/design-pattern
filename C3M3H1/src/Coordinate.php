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
        echo $this->object?->showSymbol() ?? '-';
    }

    public function swap(Coordinate $to): void
    {
        $fromObject = $this->getObject();
        $toObject = $to->getObject();

        $this->setObject($toObject);
        $to->setObject($fromObject);

        echo "move from {$this->getX()}, {$this->getY()} to {$to->getX()}, {$to->getY()}\n";
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

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
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
        return $this->searchNearby($x, $y, $range, $condition, false);
    }

    private function searchNearby(int $x, int $y, int $range, callable $condition, bool $stopAtFirst): array
    {
        $queue = [[$this->getX(), $this->getY()]];
        $visited = [];
        $results = [];
        $coordinates = $this->map->getCoordinates();

        while (! empty($queue)) {
            [$currentX, $currentY] = array_shift($queue);

            // Skip if already visited
            if (isset($visited["$currentX,$currentY"])) {
                continue;
            }

            // Mark as visited
            $visited["$currentX,$currentY"] = true;
            $current = $coordinates[$currentX][$currentY] ?? null;
            $object = $current?->getObject();

            if ($current && $condition($object) && $current !== $this) {
                $results[] = $current;
                if ($stopAtFirst) {
                    return $results;
                }
            }

            $this->addAdjacentCoordinates($queue, $visited, [$currentX, $currentY, $x, $y, $range]);
        }

        return $results;
    }

    private function addAdjacentCoordinates(array &$queue, array $visited, $params): void
    {
        [$x, $y, $maxX, $maxY, $range] = $params;

        $oriX = $this->getX();
        $oriY = $this->getY();

        for ($dx = -$maxX; $dx <= $maxX; $dx++) {
            for ($dy = -$maxY; $dy <= $maxY; $dy++) {
                if ($dx === 0 && $dy === 0) {
                    continue;
                }

                $adjX = $x + $dx;
                $adjY = $y + $dy;

                if (! isset($visited["$adjX,$adjY"]) && $this->isValidCoordinate($adjX, $adjY)) {
                    if ($oriX + $maxX < $adjX || $oriX - $maxX > $adjX || $oriY + $maxY < $adjY || $oriY - $maxY > $adjY) {
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

    private function isValidCoordinate(int $x, int $y): bool
    {
        $coordinates = $this->map->getCoordinates();

        return isset($coordinates[$x][$y]);
    }

    /**
     * 找鄰近座標中的特定物件
     */
    public function existNearbyCondition(int $x, int $y, int $range, callable $condition): bool
    {
        return ! empty($this->searchNearby($x, $y, $range, $condition, true));
    }

    /**
     * 取得方位的指定範圍, 並檢查是否有特定物件, 當遇到特定條件後停止搜尋
     */
    public function existDirectionByCondition(int $x, int $y, callable $findCondition, callable $breakCondition): bool
    {
        return ! empty($this->searchDirection($x, $y, $findCondition, $breakCondition, true));
    }

    private function searchDirection(int $x, int $y, callable $condition, callable $breakCondition, bool $stopAtFirst): array
    {
        $currentX = $this->getX();
        $currentY = $this->getY();
        $results = [];
        $coordinates = $this->map->getCoordinates();

        while (true) {
            $currentX += $x;
            $currentY += $y;

            if (! $this->isValidCoordinate($currentX, $currentY)) {
                return $results;
            }

            $current = $coordinates[$currentX][$currentY] ?? null;
            $object = $current?->getObject();

            if ($current && $condition($object) && $current !== $this) {
                $results[] = $current;
                if ($stopAtFirst) {
                    return $results;
                }
            }

            if ($current && $breakCondition($object)) {
                return $results;
            }
        }
    }

    public function findDirectionByCondition(int $x, int $y, callable $condition, callable $breakCondition): array
    {
        return $this->searchDirection($x, $y, $condition, $breakCondition, false);
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
