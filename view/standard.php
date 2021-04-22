<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;
$playerMoney = $playerMoney ?? null;
$computerMoney = $computerMoney ?? null;
$currentBet = $currentBet ?? null;

?><h1><?= $header ?></h1>

<p><?= $message ?></p>
