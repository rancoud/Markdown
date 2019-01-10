<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

/**
 * Interface Block
 *
 * @package Rancoud\Markdown
 */
interface Block
{
    /**
     * @return bool
     */
    public static function isLeaf(): bool;

    /**
     * @param string $line
     *
     * @return Block|null
     */
    public static function isMe(string $line): ?Block;

    /**
     * @return string
     */
    public function render(): string;
}