<?php

declare(strict_types=1);

use App\Coord;
use App\Individual;
use App\Showdown;
use src\Matches\StandardMatch;
use src\Strategies\DistanceBasedStrategy;

require_once dirname(__DIR__).'/vendor/autoload.php';

function initIndividuals(): array
{
    $individuals = [];
    $habits = [];
    return $individuals;
}

function generateIndividual(int $id): Individual
{
    $attribute = [
        'id' => $id
        'gender' =>
    ];


    return new Individual($attribute);

}

function getRamdomCoord(): Coord
{
    return new Coord(rand(0, 100), rand(0, 100));
}

function getRandomIndividual(array $individuals): Individual
{
    return $individuals[array_rand($individuals)];
}

$individuals = initIndividuals();
$system = new MatchmakingSystem($individuals);


$match = new StandardMatch();
$strategy = new DistanceBasedStrategy();
$individual = getRandomIndividual($system->getIndividuals());
$system->match($individual,$match, $strategy);
