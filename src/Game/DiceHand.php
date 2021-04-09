<?php

declare(strict_types=1);

namespace Jeso20\Game;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url
};

/**
 * Class DiceHand.
 */
class DiceHand
{
    private array $dices;
    private ?int $sum = null;
    private string $output = "";

    public function __construct(int $dices, int $dicsfaces)
    {
        for ($i = 0; $i < $dices; $i++) {
            $this->dices[$i] = new Dice($dicsfaces);
        }
    }

    public function roll(): void
    {
        $len = count($this->dices);

        $this->sum = 0;

        for ($i = 0; $i < $len; $i++) {
            $this->sum += $this->dices[$i]->roll();
        }
    }

    public function getLastRoll(): string
    {
        $this->output = "";
        $len = count($this->dices);

        for ($i = 0; $i < $len; $i++) {
            $this->output .= strval($this->dices[$i]->getLastRoll()) . ", ";
        }

        return substr(strval($this->output), 0, -2);
    }

    public function getDiceSum(): int
    {
        return $this->sum;
    }
}
