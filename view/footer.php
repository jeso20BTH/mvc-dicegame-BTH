</main>
<footer>
    <div class="flex row between">
        <?php if ($playerMoney) : ?>
            <p>Players money: <?= $playerMoney ?>₿</p>
        <?php endif; ?>
        <?php if ($currentBet) : ?>
            <p>Current bet: <?= $currentBet ?>₿</p>
        <?php endif; ?>
        <?php if ($computerMoney) : ?>
            <p>Computers money: <?= $computerMoney ?>₿</p>
        <?php endif; ?>
    </div>
</footer>
</body>
</html>
