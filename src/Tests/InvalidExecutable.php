<?php /** File containing class InvalidExecutable */

namespace CornyPhoenix\Tex\Tests;

use CornyPhoenix\Tex\Executables\AbstractExecutable;
use CornyPhoenix\Tex\FileFormat;

/**
 * Class to test invalid executables.
 *
 * @package CornyPhoenix\Tex\Tests
 */
class InvalidExecutable extends AbstractExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return '%invalid$';
    }

    /**
     * Returns the input format that can be processed.
     *
     * @return string
     */
    public function getInputFormat()
    {
        return FileFormat::TEX;
    }

    /**
     * Returns the output formats that can be produced.
     *
     * @return string[]
     */
    public function getOutputFormats()
    {
        return [];
    }
}
