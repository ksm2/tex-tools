<?php /** File containing class TemporaryRepository */

namespace CornyPhoenix\Tex\Repositories;

use CornyPhoenix\Tex\Exceptions\RepositoryException;

/**
 * Temporarily available repository. Use this to parse
 * a template file for example.
 *
 * @package CornyPhoenix\Tex\Repositories
 * @date 04.09.14
 * @author moellers
 */
class TemporaryRepository extends AbstractRepository
{

    /**
     * Creates a temporarily available repository.
     */
    public function __construct()
    {
        $directory = $this->createTemporaryDirectory();

        parent::__construct($directory);
    }

    /**
     * Will be called when the repository is deleted.
     */
    public function __destruct()
    {
        $this->removeDirectory();
    }

    /**
     * Creates a temporary directory to work on.
     *
     * @param string $prefix
     * @return string
     * @throws \CornyPhoenix\Tex\Exceptions\RepositoryException
     */
    private function createTemporaryDirectory($prefix = 'tex')
    {
        $tempFile = tempnam(sys_get_temp_dir(), $prefix);
        if (file_exists($tempFile)) {
            unlink($tempFile);
        }
        mkdir($tempFile);
        if (is_dir($tempFile)) {
            return $tempFile;
        }

        throw $this->createUnableToCreateTemporaryDirectoryException();
    }

    /**
     * Creates an UnableToCreateTemporaryDirectoryException.
     *
     * @return RepositoryException
     */
    private function createUnableToCreateTemporaryDirectoryException()
    {
        return new RepositoryException('It was not possible to create a temporary directory.');
    }

    /**
     * Removes the directory used by this repository.
     */
    private function removeDirectory()
    {
        if (is_dir($this->getDirectory())) {
            foreach (glob($this->getDirectory() . '/*') as $path) {
                unlink($path);
            }
            rmdir($this->getDirectory());
        }
    }
}
