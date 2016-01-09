<?php /** File containing trait LaTexJob */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Executables\LaTex;

/**
 * This trait provides LaTeX functionality for the Job class.
 *
 * @package CornyPhoenix\Tex\Jobs
 * @date 03.09.2014
 * @author moellers
 */
trait LaTexTrait
{

    /**
     * Runs the PdfLaTeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runPdfLaTex(callable $callback = null)
    {
        return $this->run(LaTex\PdfLaTexExecutable::class, $callback);
    }

    /**
     * Runs the LaTeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runLaTex(callable $callback = null)
    {
        return $this->run(LaTex\LaTexExecutable::class, $callback);
    }

    /**
     * Runs the XeLaTeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runXeLaTex(callable $callback = null)
    {
        return $this->run(LaTex\XeLaTexExecutable::class, $callback);
    }

    /**
     * Runs the LuaLaTeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runLuaLaTex(callable $callback = null)
    {
        return $this->run(LaTex\LuaLaTexExecutable::class, $callback);
    }
}
