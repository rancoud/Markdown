<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Interface Block.
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
    public static function isMe(string $line): ?self;

    /**
     * @param Markdown $markdown
     *
     * @return string
     */
    public function render(Markdown $markdown): string;

    /**
     * @param Block $block
     */
    public function appendBlock(self $block): void;

    /**
     * @return string
     */
    public function getLine(): ?string;
}
