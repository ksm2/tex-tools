<?php /** File containing interface ExecutableInterface */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex;

/**
 * Interface for executables
 *
 * @package CornyPhoenix\Tex\Executables
 */
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
     * Returns the output formats that can be produced.
     *
     * @return string[]
     */
    public function getOutputFormats();

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
     * @param \CornyPhoenix\Tex\Jobs\Job $job
     * @throws Tex\Exceptions\SpecificationException
     * @return \Symfony\Component\Process\Process
     */
    public function runJob(Tex\Jobs\Job $job);
}
