<?php

namespace C3M3H1\MapObjects\Roles;

use C3M3H1\AttackTypes\AttackType;
use C3M3H1\Enums\Direction;
use C3M3H1\MapObjects\MapObject;
use C3M3H1\MapObjects\Treasure;
use C3M3H1\States\Normal;
use C3M3H1\States\State;

abstract class Role extends MapObject
{
    public State $state;

    protected int $maxHp;

    protected int $hp;

    protected int $attack;

    protected AttackType $attackType;

    protected int $moveRange = 1;

    public function __construct()
    {
        $this->enterState(new Normal);
    }

    public function enterState(State $state): void
    {
        $this->setState($state->enterState($this));
    }

    public function setState(State $param): void
    {
        $this->state = $param;
    }

    public function takeAction(): void
    {
        if (! $this->alive()) {
            return;
        }

        $option = $this->getOption();
        $actions = $this->getActions();

        if (count($actions) === 0) {
            echo "No action can be taken\n";

            return;
        }

        // If the character is not operable, then it can only take the first action
        if (! $option->operable()) {
            $action = $actions[0];

            echo "$this->name take action: $action\n";
            echo "HP: {$this->getHp()}\n";
            echo "State: {$this->state->name}\n";

            if ($action) {
                $this->$action();
            }
        }

        // If the character is operable, then it can take choose the action
        // TODO This part is not completed yet
    }

    public function alive(): bool
    {
        return $this->getHp() > 0;
    }

    public function getHp(): int
    {
        return $this->hp;
    }

    public function setHp(int $hp): static
    {
        $this->hp = $hp;

        return $this;
    }

    public function getActions(): array
    {
        $option = $this->getOption();

        $actions = [];

        if ($this->attackable()) {
            $actions[] = 'attack';
        }

        if ($option->movable() && $this->movable()) {
            $actions[] = 'move';
        }

        return $actions;
    }

    public function attackable(): bool
    {
        $attackType = $this->getAttackType();

        return $attackType->attackable();
    }

    public function getAttackType(): AttackType
    {
        return $this->attackType;
    }

    public function setAttackType(AttackType $attackType): static
    {
        $this->attackType = $attackType;

        return $this;
    }

    public function movable(): bool
    {
        $coordinate = $this->getCoordinate();
        $condition = fn ($object) => $object === null || $object instanceof Treasure;

        $moveRange = $this->getMoveRange();
        $effected = $this->state->onMove([$moveRange, $moveRange]);
        [$x, $y] = $effected;

        return $coordinate->existNearbyCondition($x, $y, $moveRange, $condition);
    }

    public function getMoveRange(): int
    {
        return $this->moveRange;
    }

    public function move(): void
    {
        $coordinate = $this->getCoordinate();
        $condition = fn ($object) => $object === null || $object instanceof Treasure;

        $moveRange = $this->getMoveRange();
        $effected = $this->state->onMove([$moveRange, $moveRange]);
        [$x, $y] = $effected;

        $moveable = $coordinate->findNearbyCondition($x, $y, $moveRange, $condition);

        $option = $this->getOption();

        if (! $option->operable()) {
            $nextCoordinate = $moveable[array_rand($moveable)];
        } else {
            // TODO This part is operated by the user
            return;
        }

        $object = $nextCoordinate->getObject();

        if ($object instanceof Treasure) {
            $this->touch($object);
        } elseif ($object === null) {
            $originCoordinate = $this->getCoordinate();
            echo "$this->name move from {$originCoordinate->getX()}, {$originCoordinate->getY()} to {$nextCoordinate->getX()}, {$nextCoordinate->getY()}\n";

            // Set the object to the coordinate
            $this->coordinate->swap($nextCoordinate);

            // If the object is a character, then change the direction
            if ($this instanceof Character) {
                $direction = $originCoordinate->diffDirection($nextCoordinate);
                $direction = Direction::tryfrom($direction);
                $this->setDirection($direction);
            }
        }
    }

    public function touch(MapObject $object): void
    {
        if ($object instanceof Treasure) {
            $object->effect($this);
        }
    }

    public function heal(int $heal = 10): void
    {
        $hp = $this->getHp();
        $this->setHp($hp + $heal);

        echo "$this->name get heal, heal: $heal, left hp: {$this->getHp()}\n";
    }

    public function getMaxHp(): int
    {
        return $this->maxHp;
    }

    public function getAttack(): int
    {
        return $this->attack;
    }

    public function setAttack(int $int): void
    {
        $this->attack = $int;
    }

    public function onAttack(int $damage = 0): void
    {
        // The state effect the damage
        $state = $this->state;

        $effected = $state->onAttack($damage);

        $this->damage($effected);
    }

    public function damage(int $damage): void
    {
        // The hero get the damage
        $this->setHp($this->getHp() - $damage);

        // Output the damage and left hp
        $hp = $this->getHp();
        echo "$this->name get damage, damage: $damage, left hp: $hp\n";

        if ($hp <= 0) {
            $this->dead();
        }
    }

    public function dead(): void
    {
        echo "$this->name dead\n";
        $this->remove();
    }

    public function attack(): void
    {
        $attackType = $this->getAttackType();

        $attackType->attack();
    }

    public function endAction(): void
    {
        $this->state->onEndAction();
    }
}
