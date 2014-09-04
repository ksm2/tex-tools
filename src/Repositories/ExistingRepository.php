<?php /** File containing class ExistingRepository */

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
