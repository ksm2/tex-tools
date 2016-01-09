<?php /** File containing test JobTest */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\FileFormat;
use CornyPhoenix\Tex\Jobs\Job;
use CornyPhoenix\Tex\Jobs\LaTexTrait;
use CornyPhoenix\Tex\Repositories\FakeRepository;
use CornyPhoenix\Tex\Repositories\RepositoryInterface;

/**
 * Test class for TeX Jobs.
 *
 * @package CornyPhoenix\Tex\Tests
 */
class JobTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test repository
     *
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * Sets up the test.
     */
    protected function setUp()
    {
        $this->repository = new FakeRepository();
    }

    /**
     * Tests if the path properties are set correctly after Job creation.
     *
     * @test
     */
    public function testPathSetCorrectly()
    {
        $job = new Job($this->repository, 'jobname', 'the.extension');

        $this->assertEquals('jobname', $job->getName());
        $this->assertEquals('the.extension', $job->getInputFormat());
        $this->assertEquals('jobname.the.extension', $job->getInputBasename());
        $this->assertTrue($this->repository->containsFile('jobname.the.extension'));
        $this->assertEquals($this->repository->getDirectory() . '/jobname', $job->getPath());
    }

    /**
     * Tests if the provided format property is set correctly after Job creation.
     *
     * @test
     */
    public function testProvidedFormats()
    {
        $job = new Job($this->repository, 'jobname', FileFormat::TEX);

        $this->assertContains(FileFormat::TEX, $job->getProvidedFormats());
    }
}
