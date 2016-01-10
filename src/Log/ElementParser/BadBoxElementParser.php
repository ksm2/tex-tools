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
class BadBoxElementParser implements ElementParserInterface
{

    const BAD_BOX_REGEX = "/((Over|Under)full) \\\\(v|h)box \(([^\)]+)\)( in paragraph at lines (\d+))?/";

    /**
     * Parses a log element for some messages.
     *
     * @param LogElement $element
     * @return Message[]
     */
    public function parse(LogElement $element)
    {
        $messages = [];
        preg_match_all(self::BAD_BOX_REGEX, $element->getContent(), $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            list(, $overfull, , $v, $details, , $line) = $match;

            $box = $v === 'v' ? 'vertical' : 'horizontal';

            $message = sprintf('%s %s %s box.', ucfirst($details), strtolower($overfull), $box);
            $messages[] = new Message('Bad Box', Message::BAD_BOX, $element->getFilename(), $line, $message);
        }


        return $messages;
    }
}
