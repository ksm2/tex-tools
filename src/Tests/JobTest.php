<?php /** File containing test JobTest */

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\Jobs\Job;
use CornyPhoenix\Tex\Jobs\LaTexJob;

/**
 * Test class for TeX Jobs.
 *
 * @package CornyPhoenix\Tex\Tests
 */
class JobTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests if the path properties are set correctly after Job creation.
     *
     * @test
     */
    public function testPathSetCorrectly()
    {
        $job = new Job('/path/to/my/file.the.extension');

        $this->assertEquals('/path/to/my', $job->getDirectory());
        $this->assertEquals('file', $job->getName());
        $this->assertEquals('the.extension', $job->getInputFormat());
        $this->assertEquals('/path/to/my/file', $job->getPath());
    }

    /**
     * Tests if the provided format property is set correctly after Job creation.
     *
     * @test
     */
    public function testProvidedFormats()
    {
        $job = new Job('/path/to/my/file.the.extension');

        $this->assertContains('the.extension', $job->getProvidedFormats());
        $this->assertCount(1, $job->getProvidedFormats());
    }
}
