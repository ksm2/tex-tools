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
 * @package CornyPhoenix\Tex\Log
 * @author moellers
 */
class LogElement
{

    /**
     * @var LogTree
     */
    private $tree;

    /**
     * @var LogBlock
     */
    private $block;

    /**
     * @var string
     */
    private $content;

    /**
     * LogElement constructor.
     * @param LogTree $tree
     * @param LogBlock $block
     */
    public function __construct(LogTree $tree, LogBlock $block)
    {
        $this->setTree($tree);
        $this->setBlock($block);
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->block->filename;
    }

    /**
     * @return LogBlock[]
     */
    public function getStacktrace()
    {
        $stacktrace = [$this->block];
        $current = $this->block;
        while (null !== $current->parent) {
            $next = $this->tree->findBlock($current->parent);
            $stacktrace[] = $next;
            $current = $next;
        }

        return $stacktrace;
    }

    /**
     * @return LogTree
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * @param LogTree $tree
     * @return $this
     */
    public function setTree($tree)
    {
        $this->tree = $tree;
        return $this;
    }

    /**
     * @param LogBlock $block
     * @return $this
     */
    public function setBlock($block)
    {
        $this->block = $block;
        $this->content = $this->tree->getBlockContent($block);
        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->block->start >= $this->block->end;
    }
}
