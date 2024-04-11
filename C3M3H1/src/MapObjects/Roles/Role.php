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

        $actions = $this->getActions();
        if (count($actions) === 0) {
            echo "No action can be taken\n";

            return;
        }

        // If the character is not operable, then it can only take the first action
        $option = $this->getOption();
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
        $actions = [];

        if ($this->attackable()) {
            $actions[] = 'attack';
        }

        $option = $this->getOption();
        if ($option->movable() && $this->movable()) {
            $actions[] = 'move';
        }

        return $actions;
    }

    public function attackable(): bool
    {
        return $this->attackType->attackable();
    }

    public function movable(): bool
    {
        // Get the move range
        $moveRange = $this->getMoveRange();
        $effected = $this->state->onMove([$moveRange, $moveRange]);
        [$x, $y] = $effected;

        // Get the moveable condition
        $condition = fn ($object) => $object === null || $object instanceof Treasure;

        $coordinate = $this->getCoordinate();

        return $coordinate->existNearbyCondition($x, $y, $moveRange, $condition);
    }

    public function getMoveRange(): int
    {
        return $this->moveRange;
    }

    public function move(): void
    {
        // Get the move range
        $moveRange = $this->getMoveRange();
        $effected = $this->state->onMove([$moveRange, $moveRange]);
        [$x, $y] = $effected;

        // Get the moveable coordinate
        $coordinate = $this->getCoordinate();
        $condition = $this->moveableCondition();
        $moveable = $coordinate->findNearbyCondition($x, $y, $moveRange, $condition);

        if (count($moveable) === 0) {
            echo "No moveable coordinate\n";

            return;
        }

        // If the character is not operable, then it can only move randomly
        $option = $this->getOption();
        if (! $option->operable()) {
            $nextCoordinate = $moveable[array_rand($moveable)];
        } else {
            // TODO This part is operated by the user
            return;
        }

        // Touch or move the object in the next coordinate
        $object = $nextCoordinate->getObject();
        if ($object instanceof Treasure) {
            $this->touch($object);
        } elseif ($object === null) {
            // If the object is a character, then change the direction
            if ($this instanceof Character) {
                $originCoordinate = $this->getCoordinate();
                $direction = $originCoordinate->diffDirection($nextCoordinate);
                $direction = Direction::tryfrom($direction);
                $this->setDirection($direction);
            }

            // Set the object to the coordinate
            echo "$this->name ";
            $this->coordinate->swap($nextCoordinate);
        }
    }

    private function moveableCondition(): callable
    {
        return fn ($object) => $object === null || $object instanceof Treasure;
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

        // After the state effect the damage, the role get the damage
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

    public function getAttackType(): AttackType
    {
        return $this->attackType;
    }

    public function setAttackType(AttackType $attackType): static
    {
        $this->attackType = $attackType;

        return $this;
    }

    public function endAction(): void
    {
        $this->state->onEndAction();
    }
}
