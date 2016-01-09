<?php /** File containing class BibTex8Executable */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
