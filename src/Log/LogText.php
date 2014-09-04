<?php /** File containing class LogText. */

namespace CornyPhoenix\Tex\Log;

use Iterator;

/**
 * Class wrapping TeX log text logic.
 *
 * @package CornyPhoenix\Tex\Jobs
 */
class LogText implements Iterator
{

    const LOG_WRAP_LIMIT = 80;

    /**
     * All available lines.
     *
     * @var string[]
     */
    private $lines;

    /**
     * Current row index.
     *
     * @var int
     */
    private $row;

    /**
     * Creates a log text wrapper.
     *
     * @param string $text
     */
    public function __construct($text)
    {
        // Prevent CR/LF problems
        $text = preg_replace("/(\\r\\n)|\\r/", "\n", $text);

        // Join any lines which look like they have wrapped.
        $wrappedLines = explode("\n", $text);
        $this->lines = [$wrappedLines[0]];
        for ($i = 1; $i < count($wrappedLines); $i++) {
            // If the previous line is as long as the wrap limit then
            // append $this line to it.
            // Some lines end with ... when LaTeX knows it's hit the limit
            // These shouldn't be wrapped.
            if (strlen($wrappedLines[$i - 1]) == self::LOG_WRAP_LIMIT && substr($wrappedLines[$i - 1], -3) !== "...") {
                $this->lines[count($this->lines) - 1] .= $wrappedLines[$i];
            } elseif (!empty($wrappedLines[$i])) {
                $this->lines[] = $wrappedLines[$i];
            }
        }

        $this->rewind();
    }

    /**
     * Returns the next line or <code>null</code>,
     * if there are no lines remaining.
     *
     * @return null|string
     */
    public function nextLine()
    {
        $this->next();
        return $this->current();
    }

    /**
     * Returns the next line or <code>null</code>,
     * if there are no lines remaining.
     */
    public function previousLine()
    {
        $this->row--;
        return $this->current();
    }

    /**
     * Lines up everything until a pattern matches.
     *
     * @param string $pattern
     * @return string[]
     */
    public function linesUpToNextMatchingLine($pattern)
    {
        $lines = [];
        $nextLine = $this->nextLine();
        if (null !== $nextLine) {
            $lines[] = $nextLine;
        }
        while (null !== $nextLine && 0 === preg_match($pattern, $nextLine)) {
            $nextLine = $this->nextLine();
            if ($nextLine !== null) {
                $lines[] = $nextLine;
            }
        }

        return $lines;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current()
    {
        if ($this->valid()) {
            return $this->lines[$this->row];
        } else {
            return null;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next()
    {
        $this->row++;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key()
    {
        return $this->row;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return $this->row >= 0 && $this->row < count($this->lines);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        $this->row = 0;
    }
}
