<div class="flex column between">
    <?php foreach ($graphic as $dice) : ?>
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
        </div>
    <?php endforeach; ?>
</div>
