<?php /** File containing interface RepositoryInterface */

namespace CornyPhoenix\Tex\Repositories;

use CornyPhoenix\Tex\Jobs\Job;

/**
 * An interface for TeX repositories.
 *
 * A repository represents a directory in your file path where
 * TeX can do jobs in. All communication with file system is
 * canalized here.
 *
 * @package CornyPhoenix\Tex\Repositories
 * @date 04.09.2014
 * @author moellers
 */
interface RepositoryInterface
{

    /**
     * Returns the tree directory of the repository.
     *
     * @return string
     */
    public function getDirectory();

    /**
     * Creates a TeX Job by a TeX source.
     *
     * @param string $source
     * @return Job
     */
    public function createJob($source);

    /**
     * Finds an existing TeX Job by its name.
     *
     * @param string $name
     * @return Job
     */
    public function findJob($name);

    /**
     * Returns true, if a given Job is contained.
     *
     * @param \CornyPhoenix\Tex\Jobs\Job $job
     * @return bool
     */
    public function containsJob(Job $job);

    /**
     * Returns true, if a given file is contained.
     *
     * @param string $filename
     * @return bool
     */
    public function containsFile($filename);

    /**
     * Cleans the repository and leaves only job input files.
     *
     * @return void
     */
    public function clean();

    /**
     * Returns true, if no Jobs are available.
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Cleans the repository and leaves only job input files.
     *
     * @return \CornyPhoenix\Tex\Jobs\Job[]
     */
    public function getJobs();

    /**
     * Finds the provided formats to a given job.
     *
     * @param \CornyPhoenix\Tex\Jobs\Job $job
     * @return string[]
     */
    public function findFormatsByJob(Job $job);

    /**
     * Returns a string containing a contents blob.
     *
     * @param $filename
     * @return string
     */
    public function getFileBlob($filename);

    /**
     * Returns the full file path of a repository file.
     *
     * @param $filename
     * @return string
     */
    public function getFilePath($filename);
}
