<?php

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex;

interface ExecutableInterface
{

    /**
     * Returns the full path to the executable.
     *
     * @return string
     */
    public function getPath();

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns the input format that can be processed.
     *
     * @return string
     */
    public function getInputFormat();

    /**
     * Checks, whether a input format is supported.
     *
     * @param string $format
     * @return bool
     */
    public function isSupportingInputFormat($format);

    /**
     * Checks, whether a output format is supported.
     *
     * @param string $format
     * @return bool
     */
    public function isSupportingOutputFormat($format);

    /**
     * Creates a TeX job.
     *
     * @param string $inputFilePath
     * @param string $outputFormat
     * @throws \CornyPhoenix\Tex\Exceptions\SpecificationException
     * @return Tex\Job
     */
    public function createJob($inputFilePath, $outputFormat);
}
