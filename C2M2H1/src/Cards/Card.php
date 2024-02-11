<?php

namespace C2M2H1\Cards;

abstract class Card
{
    abstract public static function createCards(int $num): array;
}
