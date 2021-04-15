<?php

declare(strict_types=1);

namespace Jeso20\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use Jeso20\Game\TwentyOneGame;

use function Mos\Functions\renderView;

/**
 * Controller for the index route.
 */
class TwentyOne
{
    public function index(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["TwentyOne"] ?? new TwentyOneGame();
        $_SESSION["TwentyOne"] = $callable;

        $data = $callable->renderGame();

        $body = renderView("layout/game.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function post(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["TwentyOne"] ?? new TwentyOneGame();
        $_SESSION["TwentyOne"] = $callable;

        $data = $callable->postController();

        $body = renderView("layout/game.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}
