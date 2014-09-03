<?php

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\Jobs\Job;

class JobTest extends \PHPUnit_Framework_TestCase
{

    /**
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
     * @test
     */
    public function testProvidedFormats()
    {
        $job = new Job('/path/to/my/file.the.extension');

        $this->assertContains('the.extension', $job->getProvidedFormats());
        $this->assertCount(1, $job->getProvidedFormats());
    }
}
