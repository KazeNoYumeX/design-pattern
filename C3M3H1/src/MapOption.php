<?php

namespace C3M3H1;

class MapOption
{
    protected array $generableOptions = [];

    private bool $operable = false;

    private bool $movable = false;

    private bool $generable = false;

    public function setOperable(bool $operable): static
    {
        $this->operable = $operable;

        return $this;
    }

    public function setMovable(bool $movable): static
    {
        $this->movable = $movable;

        return $this;
    }

    public function operable(): bool
    {
        return $this->operable;
    }

    public function movable(): bool
    {
        return $this->movable;
    }

    public function generable(): bool
    {
        return $this->generable;
    }

    public function generableOptions(): array
    {
        return $this->generableOptions;
    }

    public function setGenerable(bool $generable): static
    {
        $this->generable = $generable;

        return $this;
    }

    public function setGenerableOptions(array $generableOptions): static
    {
        $this->generableOptions = $generableOptions;

        return $this;
    }
}
