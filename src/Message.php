<?php /** File containing class Message */

namespace CornyPhoenix\Tex;

/**
 * Class representing a LaTeX message.
 *
 * @package CornyPhoenix\Tex
 */
class Message
{
    const LEVEL_ERROR = 3;
    const LEVEL_WARNING = 2;
    const LEVEL_BAD_BOX = 1;
    const LEVEL_NOTE = 0;

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
    private $title;

    /**
     * Help text of this message
     *
     * @var string
     */
    private $help;

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

    /**
     * Creates a new LaTeX message.
     *
     * @param string $filename
     * @param string $help
     * @param int $level
     * @param int $line
     * @param string $title
     */
    public function __construct($filename, $help, $level, $line, $title)
    {
        $this->filename = $filename;
        $this->help = $help;
        $this->level = $level;
        $this->line = $line;
        $this->title = $title;
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
    public function getHelp()
    {
        return $this->help;
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
    public function getTitle()
    {
        return $this->title;
    }
}
