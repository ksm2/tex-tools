<?php /** File containing class PdfTexExecutable */

namespace CornyPhoenix\Tex\Executables\Tex;

use CornyPhoenix\Tex\FileFormat;

/**
 * Executable class for the PdfTeX command.
 *
 * @package CornyPhoenix\Tex\Executables\Tex
 */
class PdfTexExecutable extends TexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'pdftex';
    }

    /**
     * Returns the output formats that can be produced.
     *
     * @return string[]
     */
    public function getOutputFormats()
    {
        return [FileFormat::PDF, FileFormat::LOG, FileFormat::AUXILIARY];
    }
}
