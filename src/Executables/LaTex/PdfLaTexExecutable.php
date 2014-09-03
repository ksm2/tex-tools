<?php /** File containing class PdfLaTexExecutable */

namespace CornyPhoenix\Tex\Executables\LaTex;

use CornyPhoenix\Tex\Executables\Tex\PdfTexExecutable;

/**
 * Executable class for the PdfLaTeX command.
 *
 * @package CornyPhoenix\Tex\Executables\LaTex
 */
class PdfLaTexExecutable extends PdfTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'pdflatex';
    }
}
