<table>
    <tr class="border-bottom bold">
        <th>Combination</th>
        <?php foreach ($players as $player): ?>
            <th><?=$player["name"]?></th>
        <?php endforeach; ?>

    </tr>
    <?php foreach ($combinations["upper"] as $value): ?>
        <tr>
            <td><?= $value?></td>
            <?php foreach ($players as $player): ?>
                <td><?=$player["combinations"][$value] ?? null?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    <tr class="border-top bold">
        <td>Score</td>
        <?php foreach ($players as $player): ?>
            <td><?=$player["combinations"]["upper_sum"] ?? null?></td>
        <?php endforeach; ?>
    </tr>
    <tr class="bold italic">
        <td>Bonus</td>
        <?php foreach ($players as $player): ?>
            <td><?=$player["combinations"]["bonus"] ?? null?></td>
        <?php endforeach; ?>
    </tr>
    <tr class="border-bottom bold">
        <td>Sum</td>
        <?php foreach ($players as $player): ?>
            <td><?=$player["combinations"]["upper_score"] ?? null?></td>
        <?php endforeach; ?>
    </tr>
    <?php foreach ($combinations["lower"] as $value): ?>
        <tr>
            <td><?= $value?></td>
            <?php foreach ($players as $player): ?>
                <td><?=$player["combinations"][$value] ?? null?></td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
    <tr class="border-top bold">
        <td>Score</td>
        <?php foreach ($players as $player): ?>
            <td><?=$player["combinations"]["lower_score"] ?? null?></td>
        <?php endforeach; ?>
    </tr>
    <tr class="bolder">
        <td>Total</td>
        <?php foreach ($players as $player): ?>
            <td><?=$player["combinations"]["total_score"] ?? null?></td>
        <?php endforeach; ?>
    </tr>
</table>
