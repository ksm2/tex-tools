<?php

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
 * @package Log
 * @author moellers
 */
class LogBlock
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $nesting;

    /**
     * @var int
     */
    public $start;

    /**
     * @var int
     */
    public $end;

    /**
     * @var int|null
     */
    public $parent;

    /**
     * @var string
     */
    public $filename;
}
