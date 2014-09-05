<?php /** File containing class LogParser */

namespace CornyPhoenix\Tex\Log;

/**
 * Class LogParser
 *
 * @package CornyPhoenix\Tex\Jobs
 * @link Original JavaScript: https://github.com/jpallen/latex-log-parser/blob/master/lib/latex-log-parser.js
 */
class LogParser
{

    // Define some constants
    const GENERAL_WARNING_REGEX = "/^LaTeX Warning: (.*)$/";
    const FONT_WARNING_REGEX = "/^LaTeX Font Warning: (.*)$/";
    const FONT_SECOND_REGEX = "/^\\(Font\\)              (.*)$/";
    const BAD_BOX_REGEX = "/^(Over|Under)full \\\\(v|h)box/";
    const BIBER_WARNING_REGEX = "/^Package biblatex Warning: (.*)$/";
    const NATBIB_WARNING_REGEX = "/^Package natbib Warning: (.*)$/";

    // $this is used to parse the line number from common latex warnings
    const LINES_REGEX = "/lines? ([0-9]+)/";

    /**
     * The wrapped log text.
     *
     * @var LogText
     */
    private $logText;

    /**
     * Collects all messages.
     *
     * @var Message[]
     */
    private $messages;

    /**
     * The current file path.
     *
     * @var string[]
     */
    private $currentFileList;

    /**
     * List of all root files.
     *
     * @var string[]
     */
    private $rootFileList;

    /**
     * Count of open parenthesises.
     *
     * @var int
     */
    private $openParenthesises;

    /**
     * The currently parsed line.
     *
     * @var string
     */
    private $currentLine;

    /**
     * The currently parsed file path.
     *
     * @var string
     */
    private $currentFilePath;

    /**
     * Creates a log parser.
     *
     * @param string $text
     * @param array $options
     */
    public function __construct($text, array $options = array())
    {
        $this->logText = new LogText($text);
        $this->messages = [];
        $this->rootFileList = [];
        $this->openParenthesises = 0;
    }

    /**
     * Parses the brutal LaTeX log and returns a user friendly object.
     *
     * @return Log
     */
    public function parse()
    {
        $fileStack = array();
        foreach ($this->logText as $currentLine) {
            $this->currentLine = $currentLine;

            if ($this->currentLineIsError()) {
                $this->parseError($currentLine);
            } elseif ($this->currentLineIsWarning()) {
                $this->parseSingleWarningLine(self::GENERAL_WARNING_REGEX);
            } elseif ($this->currentLineIsFontWarning()) {
                $this->parseFontWarningLine();
            } elseif ($this->currentLineIsBadBox()) {
                $this->parseBadBoxLine();
            } elseif ($this->currentLineIsBiberWarning()) {
                $this->parseBiberWarningLine();
            } elseif ($this->currentLineIsNatbibWarning()) {
                $this->parseSingleWarningLine(self::NATBIB_WARNING_REGEX);
            } else {
                $fileStack = $this->parseParenthesisesForFileNames($fileStack);
            }
        }

        return $this->postProcess();
    }

    /**
     * Determines if the current line is an error.
     *
     * @return bool
     */
    private function currentLineIsError()
    {
        return $this->currentLine[0] == "!";
    }

    /**
     * Determines if the current line is a general LaTeX warning.
     *
     * @return bool
     */
    private function currentLineIsWarning()
    {
        return 0 !== preg_match(self::GENERAL_WARNING_REGEX, $this->currentLine);
    }

    /**
     * Determines if the current line is a general LaTeX warning.
     *
     * @return bool
     */
    private function currentLineIsFontWarning()
    {
        return 0 !== preg_match(self::FONT_WARNING_REGEX, $this->currentLine);
    }

    /**
     * Determines if the current line is a Biber warning.
     *
     * @return bool
     */
    private function currentLineIsBiberWarning()
    {
        return 0 !== preg_match(self::BIBER_WARNING_REGEX, $this->currentLine);
    }

    /**
     * Determines if the current line is a Natbib warning.
     *
     * @return bool
     */
    private function currentLineIsNatbibWarning()
    {
        return 0 !== preg_match(self::NATBIB_WARNING_REGEX, $this->currentLine);
    }

    /**
     * Determines if the current line is a bad box.
     *
     * @return bool
     */
    private function currentLineIsBadBox()
    {
        return 0 !== preg_match(self::BAD_BOX_REGEX, $this->currentLine);
    }

    /**
     * Parses a single warning line based on a regex.
     *
     * @param string $prefixRegex
     */
    private function parseSingleWarningLine($prefixRegex)
    {
        if (0 === preg_match($prefixRegex, $this->currentLine, $warningMatch)) {
            return;
        }

        $warning = $warningMatch[1];
        $line = 0 !== preg_match(self::LINES_REGEX, $warning, $lineMatch) ? intval($lineMatch[1], 10) : null;

        $this->messages[] = new Message(
            $warning,
            Message::WARNING,
            $this->currentFilePath,
            $line
        );
    }

    /**
     * Parses font warning lines.
     */
    private function parseFontWarningLine()
    {
        $subject = $this->currentLine;
        if (0 === preg_match(self::FONT_WARNING_REGEX, $subject, $warningMatch)) {
            return;
        }
        $warning = $warningMatch[1];

        $subject = $this->logText->nextLine();
        if (0 === preg_match(self::FONT_SECOND_REGEX, $subject, $warningMatch)) {
            $this->logText->previousLine();
            $content = '';
        } else {
            $content = $warningMatch[1];
        }

        $line = 0 !== preg_match(self::LINES_REGEX, $content, $lineMatch) ? intval($lineMatch[1], 10) : null;

        $this->messages[] = new Message(
            $warning,
            Message::WARNING,
            $this->currentFilePath,
            $line,
            $content
        );
    }

    /**
     * Parses a Biber warning line.
     */
    private function parseBiberWarningLine()
    {
        // Biber warnings are multiple lines, let's parse the first line
        if (0 === preg_match(self::BIBER_WARNING_REGEX, $this->currentLine, $warningMatch)) {
            // Something strange happened, return early
            return;
        }

        // Now loop over the other output and just grab the message part
        // Each line is prefiex with: (biblatex)
        $warningLines = [$warningMatch[1]];
        while ((($this->currentLine = $this->logText->nextLine()) !== false) &&
            (0 !== preg_match("/^\\(biblatex\\)[\\s]+(.*)$/", $this->currentLine, $warningMatch))) {
            $warningLines[] = $warningMatch[1];
        }

        $rawMessage = implode(' ', $warningLines);
        $this->messages[] = new Message(
            $rawMessage,
            Message::WARNING,
            $this->currentFilePath,
            null // Unfortunately, biber doesn't return a line number
        );
    }

    /**
     * Parses a bad box line.
     */
    private function parseBadBoxLine()
    {
        $line = 0 !== preg_match(self::LINES_REGEX, $this->currentLine, $lineMatch) ? intval($lineMatch[1], 10) : null;

        $this->messages[] = new Message(
            $this->currentLine,
            Message::BAD_BOX,
            $this->currentFilePath,
            $line
        );
    }

    /**
     * Parses an error message.
     *
     * @param string $currentLine
     */
    private function parseError($currentLine)
    {
        $message = substr($currentLine, 2);
        $content = implode("\n", $this->logText->linesUpToNextMatchingLine("/^l\\.[0-9]+/"));

        // Find line number
        $line = null;
        if (0 !== preg_match("/l\\.([0-9]+)/", $content, $matches)) {
            $line = intval($matches[1], 10);
        }

        $this->messages[] = new Message($message, Message::ERROR, $this->currentFilePath, $line, $content);
    }

    /**
     * Check if we're entering or leaving a new file in $this line
     *
     * @param array $fileStack
     * @return array
     */
    private function parseParenthesisesForFileNames(array $fileStack)
    {
        if (0 !== preg_match("/\\(|\\)/", $this->currentLine, $offsets, PREG_OFFSET_CAPTURE)) {
            $pos = $offsets[0][1];
            $token = $this->currentLine[$pos];
            $this->currentLine = substr($this->currentLine, $pos + 1);

            if ($token == "(") {
                $fileStack = $this->parseOpenParenthesis($fileStack);
            } elseif ($token == ")") {
                if ($this->openParenthesises > 0) {
                    $this->openParenthesises--;
                } else {
                    if (count($fileStack) > 1) {
                        array_pop($fileStack);
                        $previousFile = $fileStack[count($fileStack) - 1];
                        $this->currentFilePath = $previousFile['path'];
                        $this->currentFileList = $previousFile['files'];
                    }
                    // else {
                    //     Something has gone wrong but all we can do now is ignore it :(
                    // }
                }
            }

            // Process the rest of the line
            return $this->parseParenthesisesForFileNames($fileStack);
        }

        return $fileStack;
    }

    /**
     * Parses an opening parenthesis.
     *
     * @param array $fileStack
     * @return array
     */
    private function parseOpenParenthesis(array $fileStack)
    {
        $filePath = $this->consumeFilePath();
        if ($filePath) {
            $this->currentFilePath = $filePath;

            $newFile = array(
                'path' => $filePath,
                'files' => [],
            );
            $fileStack[] = $newFile;
            $this->currentFileList[] = $newFile;
            $this->currentFileList = $newFile['files'];
        } else {
            $this->openParenthesises++;
        }

        return $fileStack;
    }

    /**
     * Consumes the current file path.
     *
     * @return bool|string
     */
    private function consumeFilePath()
    {
        // Our heuristic for detecting file names are rather crude
        // A file may not contain a space, or ) in it
        // To be a file path it must have at least one /
        if (0 === preg_match("/^\\/?([^ \\)]+\\/)+/", $this->currentLine)) {
            return false;
        }

        $endOfFilePath = preg_match("/ |\\)/", $this->currentLine, $matches, PREG_OFFSET_CAPTURE);
        if ($endOfFilePath === 0) {
            $path = $this->currentLine;
            $this->currentLine = "";
        } else {
            $endOfFilePath = $matches[0][1];
            $path = substr($this->currentLine, 0, $endOfFilePath);
            $this->currentLine = substr($this->currentLine, $endOfFilePath);
        }

        return $path;
    }

    /**
     * Aggregation and boxing of the data.
     *
     * @return Log
     */
    private function postProcess()
    {
        $errors = [];
        $warnings = [];
        $badBoxes = [];

        foreach ($this->messages as $message) {
            switch ($message->getLevel()) {
                case Message::ERROR:
                    $errors[] = $message;
                    break;
                case Message::BAD_BOX:
                    $badBoxes[] = $message;
                    break;
                case Message::WARNING:
                    $warnings[] = $message;
                    break;
            }
        }

        return new Log($this->messages, $badBoxes, $errors, $warnings);
    }
}
