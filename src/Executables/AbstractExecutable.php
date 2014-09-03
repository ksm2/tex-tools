<?php

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex;
use CornyPhoenix\Tex\JobProcessBuilder;
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
     * @param Tex\Job $job
     * @param callable $callback
     * @return \Symfony\Component\Process\Process
     * @throws \CornyPhoenix\Tex\Exceptions\SpecificationException
     */
    public function runJob(Tex\Job $job, callable $callback = null)
    {
        $inputFilePath = $job->getPath() . '.' . $this->getInputFormat();

        if (!file_exists($inputFilePath)) {
            throw $this->createInputFileMissingException();
        } else {
            $process = $this->createProcess($job);
            $process->run($callback);
            return $process;
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
        return $this->getOutputFormat() === $format;
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
     * @param string $format
     * @return Tex\Exceptions\SpecificationException
     */
    private function createInputFormatNotSupportedException($format)
    {
        return new Tex\Exceptions\SpecificationException(
            sprintf('The input file format `%s` is not supported by %s.', $format, get_called_class())
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
     * @param \CornyPhoenix\Tex\Job $job
     * @return \Symfony\Component\Process\Process
     */
    private function createProcess(Tex\Job $job)
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
