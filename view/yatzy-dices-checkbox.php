<form class="flex row center" method="post">
    <div class="flex column between">

        <?php foreach ($graphic as $key => $dice) : ?>
            <div class="flex row center no-spacing-h">
                <div class="flex column dice <?= (count($dice) == 1) ? "center" : "between"?>">
                    <?php foreach ($dice as $row) : ?>
                        <div class="flex row <?= $row["spacing"] ?> no-spacing-h">
                            <?php for ($j = 0; $j < $row["amount"]; $j++) : ?>
                                <div class="dot"></div>
                            <?php endfor; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex column center">
                    <input class="checkbox" type="checkbox" name="dices[]" value="<?= $key?>">
                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <div class="flex column center">
        <input class="button" type="submit" name="action" value="Keep">
    </div>

</form>
