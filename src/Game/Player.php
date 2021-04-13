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
 * Class TO.
 */
class Player
{
    private ?string $type;
    private object $diceHand;
    private array $dicesToRoll = [];
    private array $combinations = [];

    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
        $this->diceHand = new DiceHand(5, 6);
    }

    public function setDicesToRoll(array $dices = [0, 1, 2, 3, 4]): void
    {
        $this->dicesToRoll = $dices;
    }

    public function getDicesToRoll(array $dicesToSave): array
    {
        $rollDices = [];
        for ($i=0; $i < 5 ; $i++) {

            if (in_array(strval($i), $dicesToSave) == false) {
                $rollDices[] = $i;
            }
        }

        return $rollDices;
    }

    public function dicesToRoll(): array
    {
        return $this->dicesToRoll;
    }

    public function rollSpecific(): void
    {
        $this->diceHand->rollSpecific($this->dicesToRoll);
    }

    public function getLastRoll(): array
    {
        return $this->diceHand->getLastRollArray();
    }

    public function getGraphicalRoll(): array
    {
        return $this->diceHand->getGraphicalRoll();
    }

    public function setSum(string $combination, int $sum): void
    {
        $this->combinations[$combination] = $sum;
    }

    public function setScore(string $combination, int $sum): void
    {
        if (array_key_exists($combination, $this->combinations) == false) {
            $this->combinations[$combination] = $sum;
        }
    }

    public function getCombinations(): array
    {
        return $this->combinations;
    }

    public function presentPlayer(): array
    {
        return [
            "name" => $this->name,
            "combinations" => $this->combinations
        ];
    }
}
