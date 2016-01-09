<?php /** File containing test ExecutableTest */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
