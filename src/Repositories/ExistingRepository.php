<?php /** File containing class ExistingRepository */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Repositories;

use CornyPhoenix\Tex\FileFormat;

/**
 * Repository for existing directories. Adds existing
 * source files automatically as jobs.
 *
 * @package CornyPhoenix\Tex\Repositories
 * @date 04.09.14
 * @author moellers
 */
class ExistingRepository extends AbstractRepository
{

    /**
     * Creates a repository from an existing directory.
     *
     * @param string $directory
     */
    public function __construct($directory)
    {
        parent::__construct($directory);

        foreach (glob($this->getDirectory() . '/*.' . FileFormat::TEX) as $path) {
            $this->addJob($this->extractName($path), FileFormat::TEX);
        }
    }
}
