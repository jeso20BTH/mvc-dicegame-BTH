<?php

declare(strict_types=1);

require  __DIR__ . "/../../vendor/autoload.php";

use Jeso20\Game\DiceHand;

session_name(preg_replace("/[^a-z\d]/i", "", __DIR__));
session_start();

$game = new DiceHand(5, 6);

$game->roll();
var_dump($game->getGraphicalRoll());
// $game->start(5);
// $game->roll("player");
// echo $game->getSum("player");
// $game->roll("computer");
// echo $game->getSum("computer");
// var_dump($game->getStandings());
