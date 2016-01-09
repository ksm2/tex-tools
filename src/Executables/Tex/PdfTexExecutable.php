<?php /** File containing class PdfTexExecutable */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
