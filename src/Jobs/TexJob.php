<?php /** File containing class TexJob */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Executables\Tex\BibTex8Executable;
use CornyPhoenix\Tex\Executables\Tex\BibTexExecutable;
use CornyPhoenix\Tex\Executables\Tex\MakeIndexExecutable;
use CornyPhoenix\Tex\Executables\Tex\PdfTexExecutable;
use CornyPhoenix\Tex\Executables\Tex\TexExecutable;
use CornyPhoenix\Tex\FileFormat;

/**
 * Class providing direct TeX commands for Jobs.
 *
 * @package CornyPhoenix\Tex\Jobs
 */
class TexJob extends Job
{

    /**
     * Cleans the job directory.
     *
     * Only TeX files will be deleted.
     * The input file will be saved.
     *
     * @return $this
     */
    public function clean()
    {
        foreach (glob($this->getPath() . '.*') as $file) {
            $format = FileFormat::fromPath($file);
            if ($format !== $this->getInputFormat() && FileFormat::isKnownFormat($format)) {
                echo "Deleting " . FileFormat::describe($format) . " ...\n";
                unlink($file);
            }
        }

        return $this;
    }

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
     * Runs the BibTeX command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runBibTex(callable $callback = null)
    {
        return $this->run(BibTexExecutable::class, $callback);
    }

    /**
     * Runs the BibTeX 8-bit command.
     *
     * @param callable $callback
     * @return $this
     */
    public function runBibTex8(callable $callback = null)
    {
        return $this->run(BibTex8Executable::class, $callback);
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
}
