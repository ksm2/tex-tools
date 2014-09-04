<?php /** File containing trait BibTexTrait */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\Executables\Tex\BibTex8Executable;
use CornyPhoenix\Tex\Executables\Tex\BibTexExecutable;

/**
 * This trait provides BibTeX functionality for the Job class.
 *
 * @package CornyPhoenix\Tex\Jobs
 * @date 04.09.14
 * @author moellers
 */
trait BibTexTrait
{

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
}
