<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$playerMoney = $playerMoney ?? null;
$computerMoney = $computerMoney ?? null;
$currentBet = $currentBet ?? null;

$header = $header ?? null;
$message = $message ?? null;
$players = $players ?? null;
$computerVictories = $standings["computer"] ?? null;
$type = $type ?? null;

$lastRoll = $lastRoll ?? null;
$roller = $roller ?? null;
$message = $message ?? null;
$graphic = $graphic ?? null;



?><h1><?= $header ?></h1>

<?php if ($type == "menu" || $type == null || $type == "add") : ?>
    <?php require __DIR__ . "/yatzy-menu.php"; ?>

<?php elseif ($type == "roll" || $type == null) : ?>
    <h2><?= $players[$playerCounter]["name"]?> turn</h2>
    <div class="flex row center">
        <div class="flex column center">
            <?php require __DIR__ . "/yatzy-scoreboard.php"; ?>
        </div>

        <?php require __DIR__ . "/yatzy-dices-checkbox.php"; ?>

    </div>
<?php elseif ($type == "place" || $type == null) : ?>
    <div class="flex row center">
        <div class="flex column center">
            <?php require __DIR__ . "/yatzy-scoreboard-place.php"; ?>
        </div>
            <?php require __DIR__ . "/yatzy-dices.php"; ?>
    </div>

<?php elseif ($type == "summary" || $type == null) : ?>
    <p class="message"><?= $message ?></p>
    <div class="flex row center">
        <?php require __DIR__ . "/yatzy-scoreboard.php"; ?>
    </div>


    <div class="flex row center">
        <form class="" method="post">
            <input class="button" type="submit" name="action" value="Menu">
        </form>
    </div>
<?php endif; ?>
