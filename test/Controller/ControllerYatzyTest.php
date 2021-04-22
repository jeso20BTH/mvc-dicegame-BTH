<?php

declare(strict_types=1);

namespace Jeso20\Controller;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * Test cases for the controller Error.
 */
class ControllerYatzyTest extends TestCase
{
    /**
     * Try to create the controller class.
     */
    public function testCreateTheControllerClass()
    {
        $controller = new Yatzy();
        $this->assertInstanceOf("\Jeso20\Controller\Yatzy", $controller);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerIndexReturnsResponse()
    {
        $controller = new Yatzy();

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->index();
        $this->assertInstanceOf($exp, $res);
    }

    /**
     * Check that the controller returns a response.
     */
    public function testControllerYatzyReturnsResponse()
    {
        $controller = new Yatzy();

        $_POST["action"] = "menu";

        $exp = "\Psr\Http\Message\ResponseInterface";
        $res = $controller->post();
        $this->assertInstanceOf($exp, $res);
    }
}
