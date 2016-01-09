<?php /** File containing class Log */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     * Creates a log object.
     *
     * @param Message[] $all
     * @param Message[] $badBoxes
     * @param Message[] $errors
     * @param Message[] $warnings
     * @internal param \string[] $rootFiles
     */
    public function __construct(array $all, array $badBoxes, array $errors, array $warnings)
    {
        $this->all = $all;
        $this->badBoxes = $badBoxes;
        $this->errors = $errors;
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
}
