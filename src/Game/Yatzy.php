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
class Yatzy
{
    private int $playerSum;
    private int $computerSum;
    private object $pointChecker;
    private array $standings;
    private string $type;
    private string $roller;
    private int $playerMoney;
    private int $computerMoney;
    private ?int $currentBet;
    private ?string $message;
    private array $graphic;
    private ?int $turnCounter = 0;
    private ?int $rollCounter = 0;
    private array $players = [];
    private int $playerCounter = 0; // Keep track of who is the current player.
    const COMBINATIONS = [
        "upper" => [
            "Ones",
            "Twos",
            "Threes",
            "Fours",
            "Fives",
            "Sixes",
        ],
        "lower" => [
            "One Pair",
            "Two Pairs",
            "Three of a Kind",
            "Four of a Kind",
            "Small Straight",
            "Large Straight",
            "Full House",
            "Chance",
            "Yatzy"
        ]
    ];
    const ROLLS = 3;


    public function __construct()
    {
        $this->type = "menu";
        $this->pointChecker = New YatzyPointChecker();
    }

    public function addPlayer(string $type, string $name): void
    {
        $this->players[] = new Player($name, $type);
    }

    public function startTurn(): void
    {
        $this->type = "roll";
        $this->rollCounter = 0;
        $this->setDicesToRoll();
        $this->roll();
    }

    public function roll(): void
    {
        $this->rollCounter++;

        if (count($this->players[$this->playerCounter]->dicesToRoll()) == 0) {
            $this->endOfRoll();
        }

        $this->players[$this->playerCounter]->rollSpecific();

        // Ha i slutet av metoden, efter ökande av tur.
        if ($this->rollCounter == self::ROLLS) {
            // Method for end of turn
            $this->endOfRoll();
        }
    }

    public function setDicesToRoll(array $dices = [0, 1, 2, 3, 4]): void
    {
        $this->players[$this->playerCounter]->setDicesToRoll($dices);
    }

    public function nextPlayer(array $dices = [0, 1, 2, 3, 4]): void
    {
        $this->players[$this->playerCounter]->setDicesToRoll($dices);
    }


    public function getPlayers(): array
    {
        return $this->players;
    }

    public function endOfRoll(): void
    {
        $this->setDicesToRoll([]);

        $this->type = "place";
    }

    public function scoreHandler(string $placement): void
    {
        $lastRoll = $this->players[$this->playerCounter]->getLastRoll();
        $sum = 0;

        $upper = [
            "Ones" => 1,
            "Twos" => 2,
            "Threes" => 3,
            "Fours" => 4,
            "Fives" => 5,
            "Sixes" => 6
        ];
        switch ($placement) {
            case 'Ones':
            case 'Twos':
            case 'Threes':
            case 'Fours':
            case 'Fives':
            case 'Sixes':
                $sum = $this->pointChecker->upper($lastRoll, $upper[$placement]);
                break;
            case 'One Pair':
                $sum = $this->pointChecker->match($lastRoll, 6, 2) * 2;
                break;
            case 'Two Pairs':
                $pairOne = $this->pointChecker->match($lastRoll, 6, 2);
                $pairTwo = $this->pointChecker->match($lastRoll, $pairOne - 1, 2);

                echo $pairOne;
                echo "\n";
                echo $pairTwo;

                $sum = $pairOne * 2 + $pairTwo * 2;

                if ($pairOne != 0 || $pairTwo != 0) {
                    $sum = 0;
                }
                break;
            case 'Three of a Kind':
                $sum = $this->pointChecker->match($lastRoll, 6, 3) * 3;
                break;
            case 'Four of a Kind':
                $sum = $this->pointChecker->match($lastRoll, 6, 4) * 4;
                break;
            case 'Small Straight':
                $sum = $this->pointChecker->straight($lastRoll, 5);
                break;
            case 'Large Straight':
                $sum = $this->pointChecker->straight($lastRoll, 6);
                break;
            case 'Full House':
                $three = $this->pointChecker->match($lastRoll, 6, 3);
                $two = $this->pointChecker->match($lastRoll, 6, 2);

                if ($three == $two) {
                    $two = $this->pointChecker->match($lastRoll, $three - 1, 2);
                }

                $sum = $three * 3 + $two * 2;

                if ($three == 0 || $two == 0) {
                    $sum = 0;
                }
                break;
            case 'Chance':
                $sum = array_sum($lastRoll) ;
                break;
            case 'Yatzy':
                $sum = $this->pointChecker->match($lastRoll, 6, 5);

                if ($sum != 0) {
                    $sum = 50;
                }
                break;
        }

        $this->players[$this->playerCounter]->setScore($placement, $sum);
        $this->setSums();

    }

    public function setSums(): void
    {
        $upperSum = 0;
        $lowerScore = 0;
        $bonus = 0;

        foreach ($this->players[$this->playerCounter]->getCombinations() as $combination => $value) {
            if (in_array($combination, self::COMBINATIONS["upper"])) {
                $upperSum += $value;
            } elseif (in_array($combination, self::COMBINATIONS["lower"])) {
                $lowerScore += $value;
            }
        }

        if ($upperSum >= 63) {
            $bonus = 50;
        }

        $upperScore = $upperSum + $bonus;
        $totalScore = $upperScore + $lowerScore;

        $this->players[$this->playerCounter]->setSum("upper_sum", $upperSum);
        $this->players[$this->playerCounter]->setSum("bonus", $bonus);
        $this->players[$this->playerCounter]->setSum("upper_score", $upperScore);
        $this->players[$this->playerCounter]->setSum("lower_score", $lowerScore);
        $this->players[$this->playerCounter]->setSum("total_score", $totalScore);
    }

    private function endTurn(string $placement): void
    {
        $this->scoreHandler($placement);

        if ($this->playerCounter == count($this->players) - 1
        && $this->turnCounter == count(self::COMBINATIONS["upper"]) + count(self::COMBINATIONS["lower"]) - 1 ) {
            $this->type = "summary";
            return;
        }

        $this->playerCounter++;

        if ($this->playerCounter > count($this->players) - 1) {
            $this->playerCounter = 0;

            $this->turnCounter ++;
        }
        $this->startTurn();


    }
    //
    // private function endGame(string $winner): void
    // {
    //     $this->type = "end";
    //     if ($winner == "player") {
    //         $this->standings["player"] += 1;
    //         $this->playerMoney += $this->currentBet;
    //         $this->computerMoney -= $this->currentBet;
    //
    //         if ($this->message == null) {
    //             $this->message = "Congratulation you won!!!";
    //         }
    //         return;
    //     } elseif ($winner == "computer") {
    //         $this->standings["computer"] += 1;
    //         $this->playerMoney -= $this->currentBet;
    //         $this->computerMoney += $this->currentBet;
    //
    //         if ($this->message == null) {
    //             $this->message = "Computer won!";
    //         }
    //     }
    //
    //     $_SESSION["standings"] = $this->standings;
    //     $this->currentBet = null;
    // }
    //

    //
    // public function start(int $dices): void
    // {
    //     $this->diceHand = new DiceHand($dices, 6);
    //
    //     $this->standings = $_SESSION["standings"] ?? array(
    //         "player" => 0,
    //         "computer" => 0
    //     );
    //
    //     $this->type = "play";
    //     $this->playerSum = 0;
    //     $this->computerSum = 0;
    //
    //     $this->roller = "player";
    //     $this->roll($this->roller);
    // }
    //
    // public function getSum(string $type): int
    // {
    //     if ($type == "player") {
    //         return $this->playerSum;
    //     }
    //     return $this->computerSum;
    // }
    //
    // public function getLastRoll(): string
    // {
    //     return $this->diceHand->getLastRoll();
    // }
    //
    // public function getStandings(): array
    // {
    //     return $this->standings;
    // }
    //
    public function postController(): array
    {
        $action = $_POST["action"];
        if ($action == "Start game") {
            $this->startTurn();



            // $this->start($dices);
        } elseif ($action == "Keep") {
            $dices = $_POST["dices"];
            $dicesToRoll = $this->players[$this->playerCounter]->getDicesToRoll($dices);
            $this->setDicesToRoll($dicesToRoll);
            $this->roll();
        } elseif ($action == "New player") {
            $this->type = "add";
        } elseif ($action == "Add player") {
            $this->type = "menu";
            $this->addPlayer($_POST["type"], $_POST["name"]);
        } elseif ($action == "Menu") {
            $this->type = "menu";
        } elseif ($action == "Place") {
            $this->endTurn($_POST["placement"]);
        }

        return $this->renderGame();
    }
    //
    // public function clearData(): void
    // {
    //     unset($_SESSION["standings"]);
    //     $this->standings = array(
    //         "player" => 0,
    //         "computer" => 0
    //     );
    //
    //     $this->playerMoney = 10;
    //     $this->computerMoney = 100;
    // }
    //
    public function getLastGraphicRoll(): array
    {
        if (count($this->players) != 0) {
            return $this->players[$this->playerCounter]->getGraphicalRoll();
        }
        return [];
    }

    public function presentPlayers(): array
    {
        $p = [];

        foreach ($this->players as $player) {
            $p[] = $player->presentPlayer();
        }
        return $p;
    }
    //
    public function renderGame(): array
    {
        $data = [
            "header" => "Lets play Yatzy!",
            "combinations" => self::COMBINATIONS,
            // "standings" => $this->getStandings(),
            "type" => $this->type,
            "players" => $this->presentPlayers(),
            // "lastRoll" => $this->getLastRoll() ?? null,
            // "roller" => $this->roller ?? null,
            "message" => $this->message ?? null,
            "title" => "Yatzy",
            "graphic" => $this->getLastGraphicRoll() ?? null,
            "playerCounter" => $this->playerCounter
        ];

        $this->message = null;

        return $data;
    }
}
