<?php

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Executables\LaTex;

class LaTexJob extends TexJob
{

    /**
     * @param callable $callback
     * @return $this
     */
    public function runPdfLaTex(callable $callback = null)
    {
        return $this->run(LaTex\PdfLaTexExecutable::class, $callback);
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function runLaTex(callable $callback = null)
    {
        return $this->run(LaTex\LaTexExecutable::class, $callback);
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function runXeLaTex(callable $callback = null)
    {
        return $this->run(LaTex\XeLatexExecutable::class, $callback);
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function runLuaLaTex(callable $callback = null)
    {
        return $this->run(LaTex\LuaLatexExecutable::class, $callback);
    }
}
