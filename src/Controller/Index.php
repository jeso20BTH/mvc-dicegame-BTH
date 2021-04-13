<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;

/**
 * Controller for the index route.
 */
class Index
{
    public function __invoke(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();

        $data = [
            "header" => "Welcome!",
            "message" => "This is a page for games. At the moment there is just one, but in the future you can find more!",
            "title" => "Home",
        ];

        $body = renderView("layout/page.php", $data);

        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }
}
