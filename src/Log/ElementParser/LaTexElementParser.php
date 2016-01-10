<?php

/*
 * This file is part of the TeX Tools for PHP component.
 *
 * (c) Konstantin S. M. Möllers <ksm.moellers@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CornyPhoenix\Tex\Log\ElementParser;

use CornyPhoenix\Tex\Log\LogElement;
use CornyPhoenix\Tex\Log\Message;

/**
 * @package CornyPhoenix\Tex\Log\ElementParser
 * @author moellers
 */
class LaTexElementParser implements ElementParserInterface
{

    const REGEX = '#(^|\n)LaTeX (\w+): (.*)#';

    /**
     * Parses a log element for some messages.
     *
     * @param LogElement $element
     * @return Message[]
     */
    public function parse(LogElement $element)
    {
        $messages = [];
        preg_match_all(self::REGEX, $element->getContent(), $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            list(, , $level, $content) = $match;

            $line = null;
            if (preg_match('# on input line (\d+)\.$#', $content, $lineMatch)) {
                list(, $line) = $lineMatch;
                $content = substr($content, 0, strlen($content) - 16 - strlen($line)) . '.';
            }

            $messages[] = new Message('LaTeX', $this->mapPackageLevel($level), $element->getFilename(), $line, $content);
        }

        return $messages;
    }

    /**
     * @param string $packageLevel
     * @return int
     */
    private function mapPackageLevel($packageLevel)
    {
        switch ($packageLevel) {
            case 'Info':
                return Message::INFO;
            case 'Warning':
                return Message::WARNING;
            case 'Message':
                return Message::DEBUG;
            default:
                return Message::ERROR;
        }
    }
}
