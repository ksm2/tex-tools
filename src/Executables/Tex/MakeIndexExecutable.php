<?php /** File containing class MakeIndexExecutable */

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
