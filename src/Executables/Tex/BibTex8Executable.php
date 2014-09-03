<?php /** File containing class BibTex8Executable */

namespace CornyPhoenix\Tex\Executables\Tex;

use CornyPhoenix\Tex\Executables\AbstractExecutable;
use CornyPhoenix\Tex\FileFormat;

/**
 * Executable class for the BibTeX 8-bit command.
 *
 * @package CornyPhoenix\Tex\Executables\Tex
 */
class BibTex8Executable extends BibTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'bibtex8';
    }
}
