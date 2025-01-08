<?php

namespace C3MB\Units\Observers;

trait WithDuplicate
{
    protected string $uniqueKey;

    protected mixed $uniqueValue;

    protected bool $executed = false;

    public function executed(): bool
    {
        return $this->executed;
    }

    public function setUniqueKey(string $attribute): static
    {
        $this->uniqueKey = $attribute;

        return $this;
    }

    public function setUniqueValue(mixed $value): static
    {
        $this->uniqueValue = $value;

        return $this;
    }

    public function validateExecuted(array $executed): void
    {
        $attribute = $this->getUniqueAttribute();

        ['key' => $key, 'value' => $value] = $attribute;

        // Check if the observer has been executed
        foreach ($executed as $executedAttribute) {
            ['key' => $executedKey, 'value' => $executedValue] = $executedAttribute;

            // If the observer has been executed, set it as executed
            if ($key === $executedKey && $value === $executedValue) {
                $this->setExecuted();

                return;
            }
        }
    }

    public function getUniqueAttribute(): array
    {
        return [
            'key' => $this->uniqueKey,
            'value' => $this->uniqueValue,
        ];
    }

    public function setExecuted(): void
    {
        $this->executed = true;
    }
}
