<?php

namespace CornyPhoenix\Tex\Results;

interface ResultInterface
{

    /**
     * @return string
     */
    public function getResultFormat();

    /**
     * @return string
     */
    public function getVersion();

    /**
     * @return \CornyPhoenix\Tex\Message[]
     */
    public function getMessages();
}
