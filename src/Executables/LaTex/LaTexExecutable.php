<?php /** File containing class LaTexExecutable */

namespace CornyPhoenix\Tex\Executables\LaTex;

use CornyPhoenix\Tex\Executables\Tex\TexExecutable;

/**
 * Executable class for the LaTeX command.
 *
 * @package CornyPhoenix\Tex\Executables\LaTex
 */
class LaTexExecutable extends TexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'latex';
    }
}
