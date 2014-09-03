<?php

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex\FileFormat;

/**
 * User: moellers
 * Date: 02.09.14
 * Time: 01:14
 */
class DviLatexExecutable extends AbstractExecutable
{
    const EXECUTABLE = 'pdflatex';

    /**
     * @return string
     */
    public function getName()
    {
        return self::EXECUTABLE;
    }

    /**
     * @return string
     */
    public function getInputFormat()
    {
        return FileFormat::TEX;
    }

    /**
     * @return string
     */
    public function getOutputFormat()
    {
        return FileFormat::DVI;
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
}
