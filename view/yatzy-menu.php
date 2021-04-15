<h2>New game</h2>
<?php if ($players) : ?>
    <h3>Players</h3>
    <?php foreach ($players as $player) : ?>
        <p><?= $player["name"] ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<form class="" method="post">
    <?php if ($type != "add" && count($players) == 0) : ?>
        <div class="flex row center">
            <input class="button" type="submit" name="action" value="New player">
        </div>
    <?php endif; ?>

    <?php if ($type == "add") : ?>
        <div class="flex row center">
            <div class="flex column center">
                <p class="input-text">Name</p>
                <input type="text" name="name" value="">
            </div>
            <div class="flex column center">
                <p class="input-text">Type</p>
                <select class="" name="type">
                    <option value="Player">Player</option>
                    <option value="Computer">Computer</option>
                </select>
            </div>
        </div>

        <div class="flex row center">
            <input class="button" type="submit" name="action" value="Add player">
        </div>
    <?php endif; ?>

    <?php if (count($players) > 0 && $players != null) : ?>
        <div class="flex row center">
            <input class="button" type="submit" name="action" value="Start game">
            <input class="button" type="submit" name="action" value="New player">
        </div>
    <?php endif; ?>




</form>
