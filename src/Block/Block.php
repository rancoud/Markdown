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
    public function isContainer(): bool;

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

    /**
     * @return Block|null
     */
    public function getParent(): ?Block;

    /**
     * @param Block $block
     */
    public function setParent(Block $block) : void;

    /**
     * @param Block $block
     *
     * @return bool
     */
    public function canClose(Block $block): bool;

    /**
     * @return bool
     */
    public function canAppend(): bool;

    /**
     * @param string $content
     */
    public function appendContent(string $content): void;
}
