<?php /** File containing class LuaLaTexExecutable */

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
