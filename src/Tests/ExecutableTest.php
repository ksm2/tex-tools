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
     * Tests if executable supporting input formats are recognized correctly.
     *
     * @test
     */
    public function testSupportedInputFileFormats()
    {
        $pdflatex = new PdfLatexExecutable();

        $this->assertTrue($pdflatex->isSupportingInputFormat(FileFormat::TEX));
        $this->assertFalse($pdflatex->isSupportingInputFormat(FileFormat::PDF));
        $this->assertFalse($pdflatex->isSupportingInputFormat(FileFormat::DVI));
        $this->assertFalse($pdflatex->isSupportingInputFormat(FileFormat::POST_SCRIPT));
    }

    /**
     * Tests if executable providing output formats are recognized correctly.
     *
     * @test
     */
    public function testSupportedOutputFileFormats()
    {
        $pdflatex = new PdfLatexExecutable();

        $this->assertTrue($pdflatex->isSupportingOutputFormat(FileFormat::PDF));
        $this->assertFalse($pdflatex->isSupportingOutputFormat(FileFormat::DVI));
        $this->assertFalse($pdflatex->isSupportingOutputFormat(FileFormat::TEX));
        $this->assertFalse($pdflatex->isSupportingOutputFormat(FileFormat::POST_SCRIPT));
    }

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
