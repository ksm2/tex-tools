<?php

namespace CornyPhoenix\Tex;

class InteractionMode
{

    /**
     * Value constants
     */
    const BATCH_MODE = 'batchmode';
    const NONSTOP_MODE = 'nonstopmode';
    const SCROLL_MODE = 'scrollmode';
    const ERROR_STOP_MODE = 'errorstopmode';

    /**
     * @var array
     */
    private static $values = [self::BATCH_MODE, self::NONSTOP_MODE, self::SCROLL_MODE, self::ERROR_STOP_MODE];

    /**
     * Should never be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * @param string $interactionMode
     * @return bool
     */
    public static function modeExists($interactionMode)
    {
        return in_array($interactionMode, self::$values);
    }
}
