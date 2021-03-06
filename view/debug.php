<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\{
    getBaseUrl,
    getCurrentUrl,
    getRoutePath
};

$header = $header ?? null;
$message = $message ?? null;
$playerMoney = $playerMoney ?? null;
$computerMoney = $computerMoney ?? null;
$currentBet = $currentBet ?? null;

echo "<h1>Debug details</h1>";

var_dump(getBaseUrl());
var_dump(getCurrentUrl());
var_dump(getRoutePath());
var_dump($_SERVER);
