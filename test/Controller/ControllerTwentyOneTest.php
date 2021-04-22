<?php

declare(strict_types=1);

namespace Jeso20\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Error.
 */
class ControllerTwentyOneTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new TwentyOne();
        $this->assertInstanceOf("\Jeso20\Controller\TwentyOne", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerIndexReturnsResponse()
    {
        $controller = new TwentyOne();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->index();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerPostReturnsResponse()
    {
        $controller = new TwentyOne();

        $_POST["action"] = "menu";

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->post();
        $this->assertInstanceOf($exp, $res);
    }
}
