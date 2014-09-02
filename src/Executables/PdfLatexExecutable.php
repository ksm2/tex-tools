<?php

namespace CornyPhoenix\Tex\Executables;

use CornyPhoenix\Tex\FileFormat;

/**
 * User: moellers
 * Date: 02.09.14
 * Time: 01:14
 */
class PdfLatexExecutable extends AbstractExecutable
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
     * @return string[]
     */
    public function getSupportedOutputFormats()
    {
        return [FileFormat::PDF, FileFormat::DVI];
    }
}
