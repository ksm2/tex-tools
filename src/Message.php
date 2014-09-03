<?php

namespace CornyPhoenix\Tex;

class Message
{
    const LEVEL_ERROR = 3;
    const LEVEL_WARNING = 2;
    const LEVEL_BAD_BOX = 1;
    const LEVEL_NOTE = 0;

    /**
     * @var int
     */
    private $level;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $help;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var int
     */
    private $line;

    /**
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
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
