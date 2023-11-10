<?php

namespace App;

use App\Enums\GenderEnum;
use src\Matches\ExchangeHands;
use src\Strategies\Card;

class Individual
{
    private readonly int $id;

    private readonly GenderEnum $gender;

    private readonly int $age;

    private string $intro;

    private Habit $habits;

    private Coord $coord;


    public function __construct(private readonly array $attribute)
    {
        $this->id = $attribute['id'] ?? 0;
        $this->gender = $this->attribute['age'];
        $this->age = $this->attribute['age'];
        $this->intro = $this->attribute['intro'];
        $this->habits = $this->attribute['habits'] ?? [];
        $this->coord = $this->attribute['coord'] ?? new Coord(0, 0);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHabits(): Habit
    {
        return $this->habits;
    }

    public function getCoord(): Coord
    {
        return $this->coord;
    }
}
