<?php

namespace CornyPhoenix\Tex;

/**
 * User: moellers
 * Date: 01.09.14
 * Time: 23:27
 */
class FileFormat
{

    const TEX = 'tex';
    const AUXILIARY = 'aux';
    const INDEX = 'idx';
    const PDF = 'pdf';
    const DVI = 'dvi';
    const POST_SCRIPT = 'ps';
    const LOG = 'log';

    /**
     * Should never be instantiated.
     */
    private function __construct()
    {
    }
}
