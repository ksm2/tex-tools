<?php

namespace CornyPhoenix\Tex;

use CornyPhoenix\Tex\Executables\DviLatexExecutable;
use CornyPhoenix\Tex\Executables\PdfLuaLatexExecutable;
use CornyPhoenix\Tex\Executables\PdfLatexExecutable;

class LaTexJob extends Job
{

    /**
     * @param callable $callback
     * @return $this
     */
    public function runPdfLaTex(callable $callback = null)
    {
        return $this->run(PdfLatexExecutable::class, $callback);
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function runDviLaTex(callable $callback = null)
    {
        return $this->run(DviLatexExecutable::class, $callback);
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function runPdfLuaLaTex(callable $callback = null)
    {
        return $this->run(PdfLuaLatexExecutable::class, $callback);
    }
}
