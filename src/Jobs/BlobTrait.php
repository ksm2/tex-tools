<?php /** File containing trait BlobTrait */

namespace CornyPhoenix\Tex\Jobs;

use CornyPhoenix\Tex\FileFormat;

/**
 * Provides methods to return blob strings for TeX's output formats.
 *
 * @package CornyPhoenix\Tex\Jobs
 * @date 04.09.14
 * @author moellers
 */
trait BlobTrait
{

    /**
     * Returns the blob string for an PDF output.
     *
     * @return string
     * @throws \CornyPhoenix\Tex\Exceptions\LogicException
     */
    public function getPdfBlob()
    {
        return $this->getBlob(FileFormat::PDF);
    }

    /**
     * Returns the blob string for an DVI output.
     *
     * @return string
     * @throws \CornyPhoenix\Tex\Exceptions\LogicException
     */
    public function getDviBlob()
    {
        return $this->getBlob(FileFormat::DVI);
    }

    /**
     * Returns the blob string for an PostScript output.
     *
     * @return string
     * @throws \CornyPhoenix\Tex\Exceptions\LogicException
     */
    public function getPostScriptBlob()
    {
        return $this->getBlob(FileFormat::POST_SCRIPT);
    }
}
