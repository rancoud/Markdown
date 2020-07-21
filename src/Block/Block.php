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
     * @param string $line
     *
     * @return Block|null
     */
    public static function getBlock(string $line): ?self;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return bool
     */
    public function isContainer(): bool;

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
    public function getParent(): ?self;

    /**
     * @param Block $block
     */
    public function setParent(self $block): void;

    /**
     * @param Block $block
     *
     * @return bool
     */
    public function canClose(self $block): bool;

    /**
     * @return bool
     */
    public function canAppend(): bool;

    /**
     * @param string $content
     */
    public function appendContent(string $content): void;
}
