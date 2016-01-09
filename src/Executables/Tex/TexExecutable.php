<?php /** File containing class TexExecutable */

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
 * Executable class for the TeX command.
 *
 * @package CornyPhoenix\Tex\Executables\Tex
 */
class TexExecutable extends AbstractExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'tex';
    }

    /**
     * Returns the input format that can be processed.
     *
     * @return string
     */
    public function getInputFormat()
    {
        return FileFormat::TEX;
    }

    /**
     * Returns the output formats that can be produced.
     *
     * @return string[]
     */
    public function getOutputFormats()
    {
        return [FileFormat::DVI, FileFormat::LOG, FileFormat::AUXILIARY];
    }
}
