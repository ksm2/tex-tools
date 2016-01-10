<?php /** File containing class LogText. */

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
 * Class wrapping TeX log text logic.
 *
 * @package CornyPhoenix\Tex\Jobs
 */
class LogText
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
     * @var string
     */
    private $prologue;

    /**
     * @var string
     */
    private $epilogue;

    /**
     * Creates a log text wrapper.
     *
     * @param string $text
     */
    public function __construct($text)
    {
        $this->setText($text);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode("\n", $this->lines);
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        // Make lines array out of text.
        $wrappedLines = explode("\n", preg_replace("/(\\r\\n)|\\r/", "\n", $text));

        // Find start and ending line.
        for ($startLine = 0; $startLine < count($wrappedLines); $startLine++) {
            if ('(' === $wrappedLines[$startLine][0]) {
                break;
            }
        }
        for ($endingLine = count($wrappedLines) - 1; $endingLine >= 0; $endingLine--) {
            if (')' === substr(rtrim($wrappedLines[$endingLine]), -1)) {
                break;
            }
        }

        // Set prologue and epilogue.
        $this->prologue = implode("\n", array_slice($wrappedLines, 0, $startLine));
        $this->epilogue = implode("\n", array_slice($wrappedLines, $endingLine + 1));

        // Cut off prologue and epilogue.
        $wrappedLines = array_slice($wrappedLines, $startLine, $endingLine - $startLine + 1);

        // Unwrap the given lines and rewind to the beginning.
        $this->lines = $this->unwrapLines($wrappedLines);
    }

    /**
     * @return \string[]
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return int
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @return string
     */
    public function getPrologue()
    {
        return $this->prologue;
    }

    /**
     * @return string
     */
    public function getEpilogue()
    {
        return $this->epilogue;
    }

    /**
     * @param array $wrappedLines
     * @return array
     */
    private function unwrapLines(array $wrappedLines)
    {
        $lines = [$wrappedLines[0]];
        for ($i = 1; $i < count($wrappedLines); $i++) {
            // If the previous line is as long as the wrap limit then
            // append $this line to it.
            // Some lines end with ... when LaTeX knows it's hit the limit
            // These shouldn't be wrapped.
            if (strlen($wrappedLines[$i - 1]) + 1 === self::LOG_WRAP_LIMIT && substr(
                    $wrappedLines[$i - 1],
                    -3
                ) !== "..."
            ) {
                $lines[count($lines) - 1] .= $wrappedLines[$i];
            } elseif (!empty($wrappedLines[$i])) {
                $lines[] = $wrappedLines[$i];
            }
        }
        return $lines;
    }
}
