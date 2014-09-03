<?php /** File containing class XeLaTexExecutable */

namespace CornyPhoenix\Tex\Executables\LaTex;

/**
 * Executable class for the XeLaTeX command.
 *
 * @package CornyPhoenix\Tex\Executables\LaTex
 */
class XeLaTexExecutable extends PdfLaTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'xelatex';
    }
}
