<?php /** File containing class FakeRepository */

namespace CornyPhoenix\Tex\Repositories;

use CornyPhoenix\Tex\FileFormat;
use CornyPhoenix\Tex\Jobs\Job;

/**
 * Just a mock repo.
 *
 * @package CornyPhoenix\Tex\Repositories
 * @date 04.09.14
 * @author moellers
 */
class FakeRepository implements RepositoryInterface
{

    /**
     * Returns the tree directory of the repository.
     *
     * @return string
     */
    public function getDirectory()
    {
        return '/some/path/here';
    }

    /**
     * Creates a TeX Job by a TeX source.
     *
     * @param string $source
     * @return Job
     */
    public function createJob($source)
    {
        return new Job($this, 'test', FileFormat::TEX);
    }

    /**
     * Finds an existing TeX Job by its name.
     *
     * @param string $name
     * @return Job
     */
    public function findJob($name)
    {
        return new Job($this, $name, FileFormat::TEX);
    }

    /**
     * Returns true, if a given Job is contained.
     *
     * @param \CornyPhoenix\Tex\Jobs\Job $job
     * @return bool
     */
    public function containsJob(Job $job)
    {
        return true;
    }

    /**
     * Returns true, if a given file is contained.
     *
     * @param string $filename
     * @return bool
     */
    public function containsFile($filename)
    {
        return true;
    }

    /**
     * Cleans the repository and leaves only job input files.
     *
     * @return void
     */
    public function clean()
    {
    }

    /**
     * Returns true, if no Jobs are available.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return false;
    }

    /**
     * Cleans the repository and leaves only job input files.
     *
     * @return \CornyPhoenix\Tex\Jobs\Job[]
     */
    public function getJobs()
    {
        return ['test' => new Job($this, 'test', FileFormat::TEX)];
    }

    /**
     * Finds the provided formats to a given job.
     *
     * @param \CornyPhoenix\Tex\Jobs\Job $job
     * @return string[]
     */
    public function findFormatsByJob(Job $job)
    {
        return [FileFormat::TEX, FileFormat::LOG, FileFormat::AUXILIARY];
    }

    /**
     * Returns a string containing a contents blob.
     *
     * @param $filename
     * @return string
     */
    public function getFileBlob($filename)
    {
        return '';
    }

    /**
     * Returns the full file path of a repository file.
     *
     * @param $filename
     * @return string
     */
    public function getFilePath($filename)
    {
        return $this->getDirectory() . '/' . $filename;
    }
}
