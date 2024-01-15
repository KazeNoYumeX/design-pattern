<?php

namespace CardGameFramework\Cards;

abstract class Card
{
    abstract public static function createCards(int $num): array;
}
