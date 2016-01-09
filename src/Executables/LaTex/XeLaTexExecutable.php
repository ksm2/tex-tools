<?php /** File containing class XeLaTexExecutable */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
