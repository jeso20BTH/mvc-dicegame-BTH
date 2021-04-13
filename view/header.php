<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;

?><!doctype html>
<html>
    <meta charset="utf-8">
    <title><?= $title ?? "No title" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?= url("/favicon.ico") ?>">
    <link rel="stylesheet" type="text/css" href="<?= url("/css/style.css") ?>">
</head>

<body>

<header>
    <nav>
        <div class="flex row end max-heigth">
            <div class="flex column end">
                <a class="round-top-right" href="<?= url("/") ?>">Home</a>
            </div>
            <div class="flex column end">
                <a href="<?= url("/twenty-one") ?>">Game 21</a>
            </div>
            <div class="flex column end">
                <a class="no-border" href="<?= url("/yatzy") ?>">Yatzy</a>
            </div>
        </div>
    </nav>
</header>
<main>
