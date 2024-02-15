<?php

namespace C2MB\Cards;

abstract class Card
{
    abstract public static function createCards(int $num): array;
}
