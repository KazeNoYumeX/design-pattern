<?php

namespace App;

use App\Enums\GenderEnum;
use InvalidArgumentException;

class Individual
{
    private readonly int $id;

    private readonly GenderEnum $gender;

    private int $age;

    private string $intro;

    private array $habits;

    private Coordinate $coordinate;

    public function __construct(private readonly array $attribute)
    {
        $this->id = $attribute['id'] ?? 0;
        $this->gender = $this->attribute['gender'];
        $this->habits = $this->attribute['habits'] ?? [];
        $this->coordinate = $this->attribute['coordinate'] ?? new Coordinate(0, 0);
        $this->setIntro($attribute['intro']);
        $this->setAge($attribute['age']);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHabit(): string
    {
        return implode(', ', array_map(fn ($habit) => $habit->getName(), $this->habits));
    }

    public function getHabits(): array
    {
        return $this->habits;
    }

    public function getCoordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function getGender(): GenderEnum
    {
        return $this->gender;
    }

    public function getIntro(): string
    {
        return $this->intro;
    }

    public function setIntro(string $intro): void
    {
        if (strlen($intro) > 200) {
            throw new InvalidArgumentException('Intro must be less than 200 characters');
        }

        $this->intro = $intro;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        if ($age < 18) {
            throw new InvalidArgumentException('Age must be greater than 18');
        }

        $this->age = $age;
    }
}
