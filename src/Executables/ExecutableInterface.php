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
     * Returns the output format that can be produced.
     *
     * @return string
     */
    public function getOutputFormat();

    /**
     * Returns prefix marking each option.
     *
     * @return string
     */
    public function getOptionPrefix();

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
     * Runs a TeX job.
     *
     * @param Tex\Job $job
     * @throws Tex\Exceptions\SpecificationException
     * @return \Symfony\Component\Process\Process
     */
    public function runJob(Tex\Job $job);
}
