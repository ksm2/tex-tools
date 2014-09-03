<?php /** File containing helper class InteractionMode */

namespace CornyPhoenix\Tex;

/**
 * Helper class for TeX interaction modes.
 *
 * @package CornyPhoenix\Tex
 */
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
     * Interaction modes known to TeX.
     *
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
     * Determines whether an interaction mode exists.
     *
     * @param string $interactionMode
     * @return bool
     */
    public static function modeExists($interactionMode)
    {
        return in_array($interactionMode, self::$values);
    }
}
