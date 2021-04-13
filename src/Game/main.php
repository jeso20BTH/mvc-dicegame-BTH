<?php

declare(strict_types=1);

require  __DIR__ . "/../../vendor/autoload.php";

use Jeso20\Game\Yatzy;

session_name(preg_replace("/[^a-z\d]/i", "", __DIR__));
session_start();

$test = new Yatzy();
//
$dices = [3, 3, 3, 2, 2];
$test->addPlayer("player", "Jesper");

$test->scoreHandler("Two Pairs", $dices);



//
// echo $test->upper($dices, 1);
// echo $test->upper($dices, 3);
// echo $test->upper($dices, 5);
//
// echo "\n";
//
// echo $test->match($dices, 5, 3);
// echo $test->match($dices, 0, 2);
//
// echo "\n";
//
// echo $test->straight($dices, 5);
// echo $test->straight($dices, 6);
// $game = new Yatzy();
//
// $game->startGame("player", "Jesper Stolt");
// // var_dump($game->getPlayers());
// $game->startTurn();
// $game->setDicesToRoll([1, 3]);
// echo "\n";
// $game->roll();
// $game->setDicesToRoll([1,]);
// echo "\n";
// $game->roll();
// $game->start(5);
// $game->roll("player");
// echo $game->getSum("player");
// $game->roll("computer");
// echo $game->getSum("computer");
// var_dump($game->getStandings());
