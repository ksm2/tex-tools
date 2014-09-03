<?php /** File containing class LaTexJob */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Executables\LaTex;

/**
 * Class providing direct LaTeX commands for Jobs.
 *
 * @package CornyPhoenix\Tex\Jobs
 */
class LaTexJob extends TexJob
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
        return $this->run(LaTex\XeLatexExecutable::class, $callback);
    }

    /**
     * Runs the LuaLaTeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runLuaLaTex(callable $callback = null)
    {
        return $this->run(LaTex\LuaLatexExecutable::class, $callback);
    }
}
