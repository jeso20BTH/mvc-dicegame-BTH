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
class TwentyOneGame
{
    private int $playerSum;
    private int $computerSum;
    private object $diceHand;
    private array $standings;
    private string $type;
    private string $roller;
    private int $playerMoney;
    private int $computerMoney;
    private ?int $currentBet;
    private ?string $message;



    public function __construct()
    {
        $this->diceHand = new DiceHand(2, 6);

        $this->playerMoney = 10;
        $this->computerMoney = 100;
        $this->standings = $_SESSION["standings"] ?? array(
            "player" => 0,
            "computer" => 0
        );
        $this->type = "menu";
    }

    private function endRoll(string $type): string
    {
        if ($type == "player") {
            if ($this->playerSum > 21) {
                $this->message = "Busted! <br> Computer wins!";
                return "over";
            } elseif ($this->playerSum == 21) {
                $this->message = "You got 21! <br> Congratulation!!!";
                return "21";
            }

            return "roll";
        }
        if ($this->computerSum > 21) {
            return "over";
        } elseif ($this->computerSum == 21) {
            return "21";
        } elseif ($this->computerSum >= 17) {
            return "stop";
        }

        return "roll";
    }

    private function endGame(string $winner): void
    {
        $this->type = "end";
        if ($winner == "player") {
            $this->standings["player"] += 1;
            $this->playerMoney += $this->currentBet;
            $this->computerMoney -= $this->currentBet;

            if ($this->message == null) {
                $this->message = "Congratulation you won!!!";
            }
            return;
        } elseif ($winner == "computer") {
            $this->standings["computer"] += 1;
            $this->playerMoney -= $this->currentBet;
            $this->computerMoney += $this->currentBet;

            if ($this->message == null) {
                $this->message = "Computer won!";
            }
        }

        $_SESSION["standings"] = $this->standings;
        $this->currentBet = null;
    }

    public function roll(string $type): void
    {
        $this->diceHand->roll();

        if ($type == "player") {
            $this->playerSum += $this->diceHand->getDiceSum();

            $result = $this->endRoll("player");
            if ($result == "over") {
                $this->endGame("computer");
            } elseif ($result == "21") {
                $this->endGame("player");
            }
            return;
        }

        $this->computerSum += $this->diceHand->getDiceSum();

        $result = $this->endRoll("computer");
        if ($result == "over") {
            $this->endGame("player");
            return;
        } elseif ($result == "21") {
            $this->endGame("computer");
            return;
        } elseif ($result == "stop") {
            if ($this->playerSum > $this->computerSum) {
                $this->endGame("player");
                return;
            }
            $this->endGame("computer");
            return;
        }
        $this->roll("Computer");
        return;
    }

    public function start(int $dices): void
    {
        $this->diceHand = new DiceHand($dices, 6);

        $this->standings = $_SESSION["standings"] ?? array(
            "player" => 0,
            "computer" => 0
        );

        $this->type = "play";
        $this->playerSum = 0;
        $this->computerSum = 0;

        $this->roller = "player";
        $this->roll($this->roller);
    }

    public function getSum(string $type): int
    {
        if ($type == "player") {
            return $this->playerSum;
        }
        return $this->computerSum;
    }

    public function getLastRoll(): string
    {
        return $this->diceHand->getLastRoll();
    }

    public function getStandings(): array
    {
        return $this->standings;
    }

    public function postController(): array
    {
        $action = $_POST["action"];
        if ($action == "Start game") {
            $dices = $_POST["dices"] ?? "1";
            $dices = intval($dices);
            $this->currentBet = intval($_POST["bet"]);
            $this->start($dices);
        } elseif ($action == "Clear data") {
            $this->clearData();
        } elseif ($action == "Roll") {
            $this->roll($this->roller);
        } elseif ($action == "Stop") {
            $this->roller = "computer";
            $this->roll($this->roller);
        } elseif ($action == "Menu") {
            $this->type = "menu";
        }

        return $this->renderGame();
    }

    public function clearData(): void
    {
        unset($_SESSION["standings"]);
        $this->standings = array(
            "player" => 0,
            "computer" => 0
        );

        $this->playerMoney = 10;
        $this->computerMoney = 100;
    }

    public function getLastGraphicRoll(): array
    {
        return $this->diceHand->getGraphicalRoll();
    }

    public function renderGame(): array
    {
        $data = [
            "header" => "Lets play 21!",
            "standings" => $this->getStandings(),
            "type" => $this->type,
            "playerSum" => $this->playerSum ?? null,
            "lastRoll" => $this->getLastRoll() ?? null,
            "computerSum" => $this->computerSum ?? null,
            "roller" => $this->roller ?? null,
            "playerMoney" => $this->playerMoney ?? null,
            "computerMoney" => $this->computerMoney ?? null,
            "currentBet" => $this->currentBet ?? null,
            "message" => $this->message ?? null,
            "title" => "21",
            "graphic" => $this->getLastGraphicRoll() ?? null
        ];

        $this->message = null;

        return $data;
    }
}
