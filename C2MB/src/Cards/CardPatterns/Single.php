<?php

namespace C2MB\Cards\CardPatterns;

class Single extends CardPattern
{
    public function match(array $cards): bool
    {
        $length = count($cards);

        return $length === 1;
    }
}
