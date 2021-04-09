<?php

declare(strict_types=1);

require  __DIR__ . "/../../vendor/autoload.php";

use Jeso20\Game\Game;

session_name(preg_replace("/[^a-z\d]/i", "", __DIR__));
session_start();

$game = new Game();


$game->start(5);
$game->roll("player");
echo $game->getSum("player");
$game->roll("computer");
echo $game->getSum("computer");
var_dump($game->getStandings());
