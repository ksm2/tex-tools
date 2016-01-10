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
class FontElementParser implements ElementParserInterface
{

    const REGEX = '#(^|\n)LaTeX Font Warning: ([^\n]*)(\n\(Font\)\s+([^\n]*))?#s';

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
            list(, , $content1, , $content2) = $match;

            $line = null;
            if (preg_match('# on input line (\d+)\.$#', $content2, $lineMatch)) {
                list(, $line) = $lineMatch;
            }

            $messages[] = new Message('Font', Message::WARNING, $element->getFilename(), $line, $content1);
        }

        return $messages;
    }
}
