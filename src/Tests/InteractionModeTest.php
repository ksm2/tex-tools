<?php

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\InteractionMode;

class InteractionModeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function testModeDoesExist()
    {
        $this->assertTrue(InteractionMode::modeExists('nonstopmode'));
        $this->assertTrue(InteractionMode::modeExists('batchmode'));
        $this->assertTrue(InteractionMode::modeExists('scrollmode'));
        $this->assertTrue(InteractionMode::modeExists('errorstopmode'));
    }

    public function testModeDoesNotExist()
    {
        $this->assertFalse(InteractionMode::modeExists('foo'));
        $this->assertFalse(InteractionMode::modeExists('nonstop'));
        $this->assertFalse(InteractionMode::modeExists(null));
        $this->assertFalse(InteractionMode::modeExists(42));
    }
}
