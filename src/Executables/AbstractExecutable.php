<?php

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex;
use Symfony\Component\Process\ExecutableFinder;

abstract class AbstractExecutable implements ExecutableInterface
{

    /**
     * @return string
     */
    public function getPath()
    {
        $finder = new ExecutableFinder();
        return $finder->find($this->getName());
    }

    /**
     * Creates a TeX job.
     *
     * @param string $inputFilePath
     * @param string $outputFormat
     * @throws \CornyPhoenix\Tex\Exceptions\SpecificationException
     * @return Tex\Job
     */
    public function createJob($inputFilePath, $outputFormat)
    {
        if (!$this->isSupportingOutputFormat($outputFormat)) {
            throw $this->createOutputFormatNotSupportedException($outputFormat);
        }

        if (!file_exists($inputFilePath)) {
            throw $this->createInputFileMissingException();
        } else {
            if (!preg_match('/^(.*)\\/([^\\/]+)\\.([^\\.]+)$/', $inputFilePath, $matches)) {
                throw $this->createMalformedInputFilePathException();
            } else {
                list(, $directory, $name, $format) = $matches;

                if (!$this->isSupportingInputFormat($format)) {
                    throw $this->createInputFormatNotSupportedException($format);
                }

                return new Tex\Job($this->getPath(), $name, $directory, $format, $outputFormat);
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
        return in_array($format, $this->getSupportedOutputFormats());
    }

    /**
     * Returns the output formats that can be produced.
     *
     * @return string[]
     */
    abstract public function getSupportedOutputFormats();

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
}
