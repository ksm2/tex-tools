<?php /** File containing class Log */

namespace CornyPhoenix\Tex\Log;

/**
 * Class Log
 * @package CornyPhoenix\Tex\Log
 */
class Log
{

    /**
     * Errors during TeX compilation.
     *
     * @var Message[]
     */
    private $errors;

    /**
     * Warnings during TeX compilation.
     *
     * @var Message[]
     */
    private $warnings;

    /**
     * Bad boxes during TeX compilation.
     *
     * @var Message[]
     */
    private $badBoxes;

    /**
     * All messages that occurred during TeX compilation.
     *
     * @var Message[]
     */
    private $all;

    /**
     * The root files.
     *
     * @var string[]
     */
    private $rootFiles;

    /**
     * Creates a log object.
     *
     * @param Message[] $all
     * @param Message[] $badBoxes
     * @param Message[] $errors
     * @param string[] $rootFiles
     * @param Message[] $warnings
     */
    public function __construct(array $all, array $badBoxes, array $errors, array $rootFiles, array $warnings)
    {
        $this->all = $all;
        $this->badBoxes = $badBoxes;
        $this->errors = $errors;
        $this->rootFiles = $rootFiles;
        $this->warnings = $warnings;
    }

    /**
     * Returns errors during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Returns warnings during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getWarnings()
    {
        return $this->warnings;
    }

    /**
     * Returns bad boxes during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getBadBoxes()
    {
        return $this->badBoxes;
    }

    /**
     * Returns all messages that occurred during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getAllMessages()
    {
        return $this->all;
    }

    /**
     * Returns root files.
     *
     * @return string[]
     */
    public function getRootFiles()
    {
        return $this->rootFiles;
    }
}
