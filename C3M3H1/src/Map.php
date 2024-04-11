<?php

namespace C3M3H1;

use C3M3H1\Enums\MapObjectEnum;
use C3M3H1\MapObjects\MapObject;
use C3M3H1\MapObjects\Roles\Monster;

class Map
{
    protected array $coordinates = [];

    protected array $initMapObjects = [];

    protected array $mapObjects = [];

    public function __construct(
        private readonly int $x,
        private readonly int $y,
    ) {
        $this->initMap();
    }

    public function initMap(): void
    {
        for ($x = 0; $x < $this->y; $x++) {
            for ($y = 0; $y < $this->x; $y++) {
                $this->coordinates[$x][$y] = new Coordinate($this, $x, $y);
            }
        }
    }

    public function findAvailableMonster(): array
    {
        return array_filter($this->mapObjects, fn ($object) => $object instanceof Monster);
    }

    public function showMap(): void
    {
        echo 'Map：'.PHP_EOL;

        for ($y = $this->getY() - 1; $y >= 0; $y--) {
            for ($x = 0; $x < $this->getX(); $x++) {
                /** @var Coordinate $coordinate */
                $coordinate = $this->coordinates[$x][$y];
                $coordinate->showSymbol();
            }
            echo PHP_EOL;
        }
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function randomGenerate(): void
    {
        $initMapObjects = $this->getInitMapObjects();
        $mapObjects = $this->generateMapObjectsFromOptions($initMapObjects);

        $canInit = $this->validateMapObjects($mapObjects);
        if ($canInit) {
            $this->generateMapObjects($mapObjects);
        }
    }

    private function getInitMapObjects(): array
    {
        return $this->initMapObjects;
    }

    private function generateMapObjectsFromOptions(array $initMapObjects): array
    {
        $mapObjects = [];

        foreach ($initMapObjects as $mapObject) {
            ['type' => $type, 'option' => $option] = $mapObject;

            /** @var MapOption $option */
            if (! $option->generable()) {
                continue;
            }

            ['number' => $number, 'rate' => $rate] = $option->generableOptions();

            for ($i = 0; $i < $number; $i++) {
                if (rand(1, 100) <= $rate * 100) {
                    $mapObjects[] = [
                        'type' => $type,
                        'number' => $number,
                        'option' => $option,
                    ];
                }
            }
        }

        return $mapObjects;
    }

    public function validateMapObjects(array $mapObjects): bool
    {
        $length = count($mapObjects);
        if ($length === 0) {
            echo 'No map objects'.PHP_EOL;

            return false;
        }

        $mapSize = $this->getX() * $this->getY();

        $existedMapObjects = $this->getMapObjects();
        $maxSize = $mapSize - count($existedMapObjects);

        if ($length > $maxSize) {
            echo 'Map objects exceed the map size'.PHP_EOL;

            return false;
        }

        return true;
    }

    public function getMapObjects(): array
    {
        return $this->mapObjects;
    }

    public function generateMapObjects(array $mapObjects): void
    {
        // Generate the map object
        foreach ($mapObjects as $mapObject) {
            ['type' => $type, 'number' => $number, 'option' => $option] = $mapObject;

            for ($i = 0; $i < $number; $i++) {
                // Pick a random coordinate
                $coordinates = $this->findEmptyCoordinates();
                $coordinate = $this->pickRandomCoordinate($coordinates);

                /** @var MapObjectEnum $type */
                $mapObject = $type->toMapObject();
                $mapObject->setOption($option);
                $this->generateMapObject($mapObject, $coordinate);
            }
        }

        $this->setInitMapObjects($mapObjects);
    }

    public function findEmptyCoordinates(): array
    {
        return array_filter($this->coordinates, function ($row) {
            $coordinates = array_filter($row, fn (Coordinate $coordinate) => $coordinate->getObject() === null);

            return $coordinates !== [];
        });
    }

    public function pickRandomCoordinate(array $coordinates): Coordinate
    {
        $row = array_rand($coordinates);
        $col = array_rand($coordinates[$row]);

        return $coordinates[$row][$col];
    }

    public function generateMapObject(MapObject $object, Coordinate $coordinate): void
    {
        // Set the object to the coordinate
        $coordinate->setObject($object);

        // Push the object to the map objects
        $this->addMapObject($object);
    }

    public function addMapObject(MapObject $object): void
    {
        $this->mapObjects[] = $object;
    }

    private function setInitMapObjects(array $mapObjects): void
    {
        $this->initMapObjects = $mapObjects;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function removeMapObject(MapObject $originObject): void
    {
        $this->mapObjects = array_filter($this->mapObjects, fn ($object) => $object !== $originObject);
    }

    public function getSize(): array
    {
        return [$this->getX(), $this->getY()];
    }
}
