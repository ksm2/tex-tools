<?php /** File containing test FileFormatTest */

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\FileFormat;

/**
 * Tests for the file format helper.
 *
 * @package CornyPhoenix\Tex\Tests
 * @date 05.09.14
 * @author moellers
 */
class FileFormatTest extends \PHPUnit_Framework_TestCase
{

    public function testKnowsFormats()
    {
        $this->assertTrue(FileFormat::isKnownFormat(FileFormat::TEX));
        $this->assertTrue(FileFormat::isKnownFormat(FileFormat::PDF));
        $this->assertTrue(FileFormat::isKnownFormat(FileFormat::AUXILIARY));
        $this->assertFalse(FileFormat::isKnownFormat('!!!'));
        $this->assertFalse(FileFormat::isKnownFormat('^$'));
        $this->assertFalse(FileFormat::isKnownFormat('.tex'));
        $this->assertFalse(FileFormat::isKnownFormat('...'));
    }

    public function testDescribe()
    {
        $this->assertEquals('TeX source file', FileFormat::describe(FileFormat::TEX));
        $this->assertEquals('Portable Document Format', FileFormat::describe(FileFormat::PDF));
        $this->assertEquals('TeX auxiliary file', FileFormat::describe(FileFormat::AUXILIARY));
        $this->assertNull(FileFormat::describe('!!!'));
        $this->assertNull(FileFormat::describe('^$'));
        $this->assertNull(FileFormat::describe('.tex'));
        $this->assertNull(FileFormat::describe('...'));
    }

    public function testFormatFromPath()
    {
        $this->assertEquals('tex', FileFormat::fromPath('/just/some/path/simple.tex'));
        $this->assertNull(FileFormat::fromPath('/just/some/path/null'));
        $this->assertEquals('dot.tex', FileFormat::fromPath('/just/some/path/withDots.dot.tex'));
        $this->assertEquals('dot.dot.tex', FileFormat::fromPath('/just/some/path/withMoreDots.dot.dot.tex'));
        $this->assertNull(FileFormat::fromPath('/just/some/path/no/file/'));
        $this->assertNull(FileFormat::fromPath('/'));
        $this->assertNull(FileFormat::fromPath('.'));
        $this->assertNull(FileFormat::fromPath(''));
    }
}
