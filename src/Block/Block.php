<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;
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
     * @param Markdown $markdown
     *
     * @return string
     */
    public function render(Markdown $markdown): string;
}