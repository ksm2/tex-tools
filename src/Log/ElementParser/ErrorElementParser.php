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
class ErrorElementParser implements ElementParserInterface
{

    const REGEX = '#(^|\n)! ([^\n]*)\n(l.(\d+)[^\n]*)#s';

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
            list(, , $message, $content, $line) = $match;

            $messages[] = new Message(rtrim($message, '.'), Message::ERROR, $element->getFilename(), $line, $content);
        }

        return $messages;
    }
}
