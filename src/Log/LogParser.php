<?php /** File containing class LogParser */

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Log;

use CornyPhoenix\Tex\Log\ElementParser\BadBoxElementParser;
use CornyPhoenix\Tex\Log\ElementParser\DebugElementParser;
use CornyPhoenix\Tex\Log\ElementParser\ErrorElementParser;
use CornyPhoenix\Tex\Log\ElementParser\FontElementParser;
use CornyPhoenix\Tex\Log\ElementParser\LaTexElementParser;
use CornyPhoenix\Tex\Log\ElementParser\ElementParserInterface;
use CornyPhoenix\Tex\Log\ElementParser\PackageElementParser;

/**
 * Class LogParser
 *
 * @package CornyPhoenix\Tex\Jobs
 * @link Original JavaScript: https://github.com/jpallen/latex-log-parser/blob/master/lib/latex-log-parser.js
 */
class LogParser
{

    /**
     * The wrapped log text.
     *
     * @var LogText
     */
    private $logText;

    /**
     * A tree containing the log info.
     *
     * @var LogTree
     */
    private $logTree;

    /**
     * @var ElementParserInterface[]
     */
    private $messageParsers;

    /**
     * Creates a log parser.
     *
     * @param string $text
     */
    public function __construct($text)
    {
        $this->logText = new LogText($text);
        $this->logTree = new LogTree($this->logText);

        $this->messageParsers = [
            new PackageElementParser(),
            new BadBoxElementParser(),
            new LaTexElementParser(),
            new FontElementParser(),
            new DebugElementParser(),
            new ErrorElementParser(),
        ];
    }

    /**
     * Parses the brutal LaTeX log and returns a user friendly object.
     *
     * @return Log
     */
    public function parse()
    {
        $messages = [];
        foreach ($this->logTree as $element) {
            if ($element->isEmpty()) {
                continue;
            }

            foreach ($this->messageParsers as $messageParser) {
                $messages = array_merge($messages, $messageParser->parse($element));
            }
        }

        return new Log($messages);
    }
}
