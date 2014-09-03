<?php

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex;
use CornyPhoenix\Tex\JobProcessBuilder;
use CornyPhoenix\Tex\Jobs\Job;
use Symfony\Component\Process\ExecutableFinder;

abstract class AbstractExecutable implements ExecutableInterface
{

    /**
     * @var JobProcessBuilder
     */
    private $processBuilder;

    /**
     * @var string
     */
    private $path;

    /**
     * Creates a new TeX executable.
     */
    public function __construct()
    {
        // Find executable
        $finder = new ExecutableFinder();
        $this->path = $finder->find($this->getName());

        // Create a process builder
        $this->processBuilder = $this->createProcessBuilder();
    }

    /**
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
     * @return Tex\Exceptions\SpecificationException
     */
    private function createInputFileMissingException()
    {
        return new Tex\Exceptions\SpecificationException('The input file specified is not existing.');
    }

    /**
     * @return Tex\Exceptions\SpecificationException
     */
    private function createMalformedInputFilePathException()
    {
        return new Tex\Exceptions\SpecificationException(
            'The input file is not correct, maybe the extension is missing.'
        );
    }

    /**
     * @param Job $job
     * @return Tex\Exceptions\SpecificationException
     */
    private function createInputFormatNotProvidedException(Job $job)
    {
        return new Tex\Exceptions\SpecificationException(
            sprintf('The input file format `%s` is not provided by job %s.', $this->getInputFormat(), $job->getName())
        );
    }

    /**
     * @param string $format
     * @return Tex\Exceptions\SpecificationException
     */
    private function createOutputFormatNotSupportedException($format)
    {
        return new Tex\Exceptions\SpecificationException(
            sprintf('The output file format `%s` is not supported by %s.', $format, get_called_class())
        );
    }

    /**
     * @param Job $job
     * @return \Symfony\Component\Process\Process
     */
    protected function createProcess(Job $job)
    {
        $process = $this->processBuilder->setJob($job)->getProcess();
        return $process;
    }

    /**
     * @return JobProcessBuilder
     */
    private function createProcessBuilder()
    {
        return new JobProcessBuilder($this);
    }
}
