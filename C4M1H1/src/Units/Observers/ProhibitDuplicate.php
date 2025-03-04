<?php

namespace C3MB\Units\Observers;

interface ProhibitDuplicate
{
    public function executed(): bool;

    public function getUniqueAttribute(): array;

    public function validateExecuted(array $executed): void;
}
