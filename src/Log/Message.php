<?php /** File containing class Message */

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
 * Class representing a LaTeX message.
 *
 * @package CornyPhoenix\Tex\Log
 */
class Message
{
    const DEBUG = 0;
    const INFO = 1;
    const BAD_BOX = 2;
    const WARNING = 3;
    const ERROR = 4;

    /**
     * The message log level
     *
     * @var int
     */
    private $level;

    /**
     * Title of this message
     *
     * @var string
     */
    private $message;

    /**
     * Help text of this message
     *
     * @var string
     */
    private $content;

    /**
     * The filename which produced the message
     *
     * @var string
     */
    private $filename;

    /**
     * The line in the filename producing the message
     *
     * @var int
     */
    private $line;

    private static $levels = [
        self::DEBUG     => 'debug',
        self::INFO      => 'info',
        self::BAD_BOX   => 'badbox',
        self::WARNING   => 'warning',
        self::ERROR     => 'error',
    ];

    /**
     * Creates a new LaTeX message.
     *
     * @param string $message
     * @param int $level
     * @param string $filename
     * @param int $line
     * @param string $content
     */
    public function __construct($message, $level, $filename, $line, $content = '')
    {
        $this->message = $message;
        $this->level = intval($level);
        $this->filename = $filename;
        $this->line = null === $line ? null : intval($line);
        $this->content = $content;
    }

    /**
     * Returns the filename which produced the message.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Returns the help text of this message.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Returns the message log level.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getLevelStr()
    {
        return self::$levels[$this->getLevel()];
    }

    /**
     * Returns the line in the filename producing the message.
     *
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * Returns title of this message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
