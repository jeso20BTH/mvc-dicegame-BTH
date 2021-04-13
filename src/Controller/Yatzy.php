<?php

declare(strict_types=1);

namespace Jeso20\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\{
    destroySession,
    renderView,
    url
};



/**
 * Controller for the index route.
 */
class Yatzy
{
    public function index(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["Yatzy"] ?? new \Jeso20\Game\Yatzy();
        $_SESSION["Yatzy"] = $callable;

        $data = $callable->renderGame();

        $body = renderView("layout/yatzy.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function post(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $callable = $_SESSION["Yatzy"] ?? new \Jeso20\Game\Yatzy();
        $_SESSION["Yatzy"] = $callable;

        $data = $callable->postController();

        return (new Response())
            ->withStatus(301)
            ->withHeader("Location", url("/yatzy"));
    }
}
