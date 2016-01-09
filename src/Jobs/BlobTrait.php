<?php /** File containing trait BlobTrait */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
