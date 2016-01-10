<?php /** File containing class Log */

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
 * Class Log
 * @package CornyPhoenix\Tex\Log
 */
class Log
{

    /**
     * All messages that occurred during TeX compilation.
     *
     * @var Message[]
     */
    private $messages;

    /**
     * Creates a log object.
     *
     * @param Message[] $messages
     */
    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Returns errors during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getErrors()
    {
        return array_filter($this->messages, function (Message $message) {
            return Message::ERROR === $message->getLevel();
        });
    }

    /**
     * Returns warnings during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getWarnings()
    {
        return array_filter($this->messages, function (Message $message) {
            return Message::WARNING === $message->getLevel();
        });
    }

    /**
     * Returns bad boxes during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getBadBoxes()
    {
        return array_filter($this->messages, function (Message $message) {
            return Message::BAD_BOX === $message->getLevel();
        });
    }

    /**
     * Returns all messages that occurred during TeX compilation.
     *
     * @return \CornyPhoenix\Tex\Log\Message[]
     */
    public function getAllMessages()
    {
        return $this->messages;
    }
}
