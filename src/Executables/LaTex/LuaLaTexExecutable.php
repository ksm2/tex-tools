<?php /** File containing class LuaLaTexExecutable */

namespace CornyPhoenix\Tex\Executables\LaTex;

/**
 * Executable class for the LuaLaTeX command.
 *
 * @package CornyPhoenix\Tex\Executables\LaTex
 */
class LuaLaTexExecutable extends PdfLaTexExecutable
{

    /**
     * Returns the file name of the executable.
     *
     * @return string
     */
    public function getName()
    {
        return 'lualatex';
    }

    /**
     * Returns prefix marking each option.
     *
     * @return string
     */
    public function getOptionPrefix()
    {
        return '--';
    }
}
