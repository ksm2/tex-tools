<?php /** File containing class AbstractRepository */

namespace CornyPhoenix\Tex\Repositories;

use CornyPhoenix\Tex\Exceptions\RepositoryException;
use CornyPhoenix\Tex\FileFormat;
use CornyPhoenix\Tex\Jobs\Job;

/**
 * An abstract implementation of the RepositoryInterface.
 *
 * @package CornyPhoenix\Tex\Repositories
 * @date 04.09.14
 * @author moellers
 */
abstract class AbstractRepository implements RepositoryInterface
{
    const TEMP_FILE_PREFIX = 'job';

    /**
     * The tree directory of the repository.
     *
     * @var string
     */
    private $directory;

    /**
     * The jobs contained by this repository.
     *
     * @var Job[]
     */
    private $jobs;

    /**
     * Creates an abstract repository object.
     *
     * @param string $directory
     * @throws \CornyPhoenix\Tex\Exceptions\RepositoryException
     */
    public function __construct($directory)
    {
        if (!is_dir($directory)) {
            throw $this->createInvalidRepositoryDirectoryException();
        }
        $this->directory = $directory;
        $this->jobs = [];
    }

    /**
     * Returns the tree directory of the repository.
     *
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Creates a TeX Job by a TeX source.
     *
     * @param string $source
     * @return Job
     */
    public function createJob($source)
    {
        $format = FileFormat::TEX;
        $jobFile = $this->generateJobFile($format);
        file_put_contents($jobFile, $source);

        return $this->addJob($this->extractName($jobFile), $format);
    }

    /**
     * Finds an existing TeX Job by its name.
     *
     * @param string $name
     * @return Job
     */
    public function findJob($name)
    {
        return $this->jobs[$name];
    }

    /**
     * Returns true, if a given Job is contained.
     *
     * @param \CornyPhoenix\Tex\Jobs\Job $job
     * @return bool
     */
    public function containsJob(Job $job)
    {
        return isset($this->jobs[$job->getName()]);
    }

    /**
     * Cleans the repository and leaves only job input files.
     *
     * @return \CornyPhoenix\Tex\Jobs\Job[]
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Finds the provided formats to a given job.
     *
     * @param \CornyPhoenix\Tex\Jobs\Job $job
     * @return string[]
     */
    public function findFormatsByJob(Job $job)
    {
        return array_map(
            function ($path) {
                return FileFormat::fromPath($path);
            },
            glob($this->directory . '/' . $job->getName() . '.*')
        );
    }

    /**
     * Returns true, if a given file is contained.
     *
     * @param string $filename
     * @return bool
     */
    public function containsFile($filename)
    {
        return is_file($this->directory . '/' . $filename);
    }

    /**
     * Cleans the repository and leaves only job input files.
     *
     * @return void
     */
    public function clean()
    {
        foreach ($this->jobs as $job) {
            $job->clean();
        }
    }

    /**
     * Returns true, if no Jobs are available.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->jobs);
    }

    /**
     * Returns a string containing a contents blob.
     *
     * @param $filename
     * @return mixed
     */
    public function getFileBlob($filename)
    {
        return file_get_contents($this->getFilePath($filename));
    }

    /**
     * Returns the full file path of a repository file.
     *
     * @param $filename
     * @return string
     */
    public function getFilePath($filename)
    {
        return $this->directory . '/' . $filename;
    }

    /**
     * Adds a job to the repository.
     *
     * @param string $name
     * @param string $format
     * @return Job
     */
    protected function addJob($name, $format)
    {
        $job = new Job($this, $name, $format);
        $this->jobs[$name] = $job;

        return $job;
    }

    /**
     * Finds the Job name by an absolute file path.
     *
     * @param string $path
     * @return string
     */
    protected function extractName($path)
    {
        $directory = dirname($path);
        $format = FileFormat::fromPath($path);
        $directoryLength = strlen($directory);
        $formatLength = strlen($format);

        return substr($path, $directoryLength + 1, strlen($path) - $formatLength - $directoryLength - 2);
    }

    /**
     * Generates a file for a new TeX Job.
     *
     * @param string $format
     * @return string
     */
    private function generateJobFile($format)
    {
        do {
            $temp = tempnam($this->directory, self::TEMP_FILE_PREFIX);
            $tempExt = $temp . '.' . $format;
            unlink($temp);
        } while (file_exists($tempExt));

        touch($tempExt);
        return $tempExt;
    }

    /**
     * Creates an InvalidRepositoryDirectoryException.
     *
     * @return RepositoryException
     */
    private function createInvalidRepositoryDirectoryException()
    {
        return new RepositoryException('The directory you specified for this repository is invalid.');
    }
}
