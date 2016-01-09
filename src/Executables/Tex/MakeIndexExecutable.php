<?php /** File containing class MakeIndexExecutable */

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
 * Executable class for the MakeIndex command.
 *
 * @package CornyPhoenix\Tex\Executables\Tex
 */
class MakeIndexExecutable extends BibTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'makeindex';
    }

    /**
     * Returns the input format that can be processed.
     *
     * @return string
     */
    public function getInputFormat()
    {
        return FileFormat::INDEX;
    }

    /**
     * Returns the output formats that can be produced.
     *
     * @return string[]
     */
    public function getOutputFormats()
    {
        return [FileFormat::INDEX_AUXILIARY, FileFormat::INDEX_LOG];
    }
}
