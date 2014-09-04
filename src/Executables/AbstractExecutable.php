<?php /** File containing class AbstractExecutable */

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex;
use CornyPhoenix\Tex\JobProcessBuilder;
use CornyPhoenix\Tex\Jobs\Job;
use Symfony\Component\Process\ExecutableFinder;

/**
 * Abstract class providing general executable logic.
 *
 * @package CornyPhoenix\Tex\Executables
 */
abstract class AbstractExecutable implements ExecutableInterface
{

    /**
     * A process builder operated by this executable.
     *
     * @var JobProcessBuilder
     */
    private $processBuilder;

    /**
     * The file path to the executable on the operating system.
     *
     * @var string
     */
    private $path;

    /**
     * Creates a new TeX executable.
     *
     * @throws \CornyPhoenix\Tex\Exceptions\MissingExecutableException
     */
    public function __construct()
    {
        // Find executable
        $finder = new ExecutableFinder();
        $this->path = $finder->find($this->getName());

        if (null === $this->path) {
            throw $this->createMissingExecutableException();
        }

        // Create a process builder
        $this->processBuilder = $this->createProcessBuilder();
    }

    /**
     * Returns the file path to the executable on the operating system.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Runs a TeX job.
     *
     * @param Job $job
     * @param callable $callback
     * @return \Symfony\Component\Process\Process
     * @throws \CornyPhoenix\Tex\Exceptions\SpecificationException
     */
    public function runJob(Job $job, callable $callback = null)
    {
        if (!in_array($this->getInputFormat(), $job->getProvidedFormats())) {
            throw $this->createInputFormatNotProvidedException($job);
        } else {
            $inputFilePath = $job->getPath() . '.' . $this->getInputFormat();

            if (!file_exists($inputFilePath)) {
                throw $this->createInputFileMissingException();
            } else {
                $process = $this->createProcess($job);
                $exitCode = $process->run($callback);

                if ($exitCode === 0) {
                    $job->addProvidedFormats($this->getOutputFormats());
                }

                return $process;
            }
        }
    }

    /**
     * Returns prefix marking each option.
     *
     * @return string
     */
    public function getOptionPrefix()
    {
        return '-';
    }

    /**
     * Checks, whether a input format is supported.
     *
     * @param string $format
     * @return bool
     */
    final public function isSupportingInputFormat($format)
    {
        return $this->getInputFormat() === $format;
    }

    /**
     * Checks, whether a output format is supported.
     *
     * @param string $format
     * @return bool
     */
    final public function isSupportingOutputFormat($format)
    {
        return in_array($format, $this->getOutputFormats());
    }

    /**
     * Creates a process for a TeX Job.
     *
     * @param Job $job
     * @return \Symfony\Component\Process\Process
     */
    protected function createProcess(Job $job)
    {
        $process = $this->processBuilder->setJob($job)->getProcess();
        return $process;
    }

    /**
     * Creates the process builder.
     *
     * @return JobProcessBuilder
     */
    private function createProcessBuilder()
    {
        return new JobProcessBuilder($this);
    }

    /**
     * Creates an MissingExecutableException.
     *
     * @return Tex\Exceptions\MissingExecutableException
     */
    private function createMissingExecutableException()
    {
        $f = 'Could not find `%s` on your system – have you checked "open_basedir" in php.ini?';
        return new Tex\Exceptions\MissingExecutableException(sprintf($f, $this->getName()));
    }

    /**
     * Creates an InputFileMissingException.
     *
     * @return Tex\Exceptions\SpecificationException
     */
    private function createInputFileMissingException()
    {
        return new Tex\Exceptions\SpecificationException('The input file specified is not existing.');
    }

    /**
     * Creates an InputFormatNotProvidedException.
     *
     * @param Job $job
     * @return Tex\Exceptions\SpecificationException
     */
    private function createInputFormatNotProvidedException(Job $job)
    {
        return new Tex\Exceptions\SpecificationException(
            sprintf('The input file format `%s` is not provided by job %s.', $this->getInputFormat(), $job->getName())
        );
    }
}
