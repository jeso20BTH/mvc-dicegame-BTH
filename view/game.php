<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

$header = $header ?? null;
$message = $message ?? null;
$playerVictories = $standings["player"] ?? null;
$computerVictories = $standings["computer"] ?? null;
$type = $type ?? null;
$playerSum = $playerSum ?? 0;
$computerSum = $computerSum ?? 0;
$lastRoll = $lastRoll ?? null;
$roller = $roller ?? null;
$playerMoney = $playerMoney ?? 0;
$computerMoney = $computerMoney ?? 0;
$currentBet = $currentBet ?? null;
$message = $message ?? null;
$graphic = $graphic ?? null;

?><h1><?= $header ?></h1>

<?php if ($type == "menu" || $type == null) : ?>
    <?php if ($playerVictories + $computerVictories != 0) : ?>
        <h2>Statistics</h2>
        <p>Games played: <?= $playerVictories + $computerVictories ?></p>
        <p>Player: <?= $playerVictories ?> - Computer: <?= $computerVictories ?></p>
    <?php endif; ?>

    <h2>New game</h2>

    <form class="" method="post">
        <h3>Dices</h3>
        <div class="flex row center">
            <p>1</p>
            <label class="switch">
              <input type="checkbox" name="dices" value="2">
              <span class="slider round"></span>
            </label>
            <p>2</p>
        </div>
        <div class="flex row center">
            <p>Place your bet: </p>
            <input type="number" id="bet" name="bet" min="0" max="<?= ceil($playerMoney / 2) ?>">
        </div>

        <div class="flex row center">
            <input class="button" type="submit" name="action" value="Start game">
            <input class="button" type="submit" name="action" value="Clear data">
        </div>

    </form>
<?php elseif ($type == "play" || $type == null) : ?>
    <h2>Players turn</h2>
    <p>Player: <?= $playerSum ?></p>
    <div class="flex row center">
        <?php foreach ($graphic as $dice) : ?>
            <div class="flex column dice <?= (count($dice) == 1) ? "center" : "between"?>">
                <?php foreach ($dice as $row) : ?>
                    <div class="flex row <?= $row["spacing"] ?> no-spacing-h">
                        <?php for ($j = 0; $j < $row["amount"]; $j++) : ?>
                            <div class="dot"></div>
                        <?php endfor; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

    </div>
    <form class="" method="post">
        <div class="flex row center">
            <input class="button" type="submit" name="action" value="Roll">
            <input class="button" type="submit" name="action" value="Stop">
        </div>

    </form>
<?php elseif ($type == "end" || $type == null) : ?>
    <p class="message"><?= $message ?></p>
    <div class="flex row center">
        <p>Player: <?= $playerSum ?></p>
        <?php if ($computerSum != 0) : ?>
            <p>Computer: <?= $computerSum ?></p>
        <?php endif; ?>
    </div>

    <div class="flex row center">
        <form class="" method="post">
            <input class="button" type="submit" name="action" value="Menu">
        </form>
    </div>
<?php endif; ?>
