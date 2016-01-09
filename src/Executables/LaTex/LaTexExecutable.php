<?php /** File containing class LaTexExecutable */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
