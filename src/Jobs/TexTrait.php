<?php /** File containing trait TexJob */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Executables\Tex\BibTex8Executable;
use CornyPhoenix\Tex\Executables\Tex\BibTexExecutable;
use CornyPhoenix\Tex\Executables\Tex\DviPsExecutable;
use CornyPhoenix\Tex\Executables\Tex\MakeIndexExecutable;
use CornyPhoenix\Tex\Executables\Tex\PdfTexExecutable;
use CornyPhoenix\Tex\Executables\Tex\TexExecutable;
use CornyPhoenix\Tex\FileFormat;

/**
 * This trait provides TeX functionality for the Job class.
 *
 * @package CornyPhoenix\Tex\Jobs
 * @date 03.09.2014
 * @author moellers
 */
trait TexTrait
{

    /**
     * Runs the TeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runTex(callable $callback = null)
    {
        return $this->run(TexExecutable::class, $callback);
    }

    /**
     * Runs the PdfTeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runPdfTex(callable $callback = null)
    {
        return $this->run(PdfTexExecutable::class, $callback);
    }

    /**
     * Runs the MakeIndex command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runMakeIndex(callable $callback = null)
    {
        $this->addProvidedFormats([FileFormat::INDEX]);

        return $this->run(MakeIndexExecutable::class, $callback);
    }

    /**
     * Runs the DviPs command, which converts DVI
     * file format to PostScript.
     *
     * @param callable $callback
     * @return $this
     */
    public function runDviPs(callable $callback = null)
    {
        return $this->run(DviPsExecutable::class, $callback);
    }
}
