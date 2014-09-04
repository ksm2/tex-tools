<?php /** File containing test ExecutableTest */

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\Executables\LaTex\PdfLaTexExecutable;
use CornyPhoenix\Tex\FileFormat;

/**
 * Test class for executables.
 *
 * @package CornyPhoenix\Tex\Tests
 */
class ExecutableTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests if an exception will be thrown if executable is missing.
     *
     * @expectedException \CornyPhoenix\Tex\Exceptions\MissingExecutableException
     * @test
     */
    public function testMissingExecutable()
    {
        new InvalidExecutable();
    }
}
