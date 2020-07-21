<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;
use Rancoud\Markdown\MarkdownException;

/**
 * Class ListBlock.
 */
class ListBlock implements Block
{
    protected array $blocks = [];

    /**
     * @param string $line
     *
     * @return Block|null
     */
    public static function getBlock(string $line): ?Block
    {
        return (\trim($line) === '-') ? new self() : null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ListBlock';
    }

    /**
     * @return bool
     */
    public function isContainer(): bool
    {
        return true;
    }

    /**
     * @param Markdown $markdown
     *
     * @return string
     */
    public function render(Markdown $markdown): string
    {
        return '';
    }

    /**
     * @param Block $block
     */
    public function appendBlock(Block $block): void
    {
        $this->blocks[] = $block;
    }

    /**
     * @return string
     */
    public function getLine(): ?string
    {
        return null;
    }

    /**
     * @param Block $block
     */
    public function setParent(Block $block): void
    {
    }

    /**
     * @return Block|null
     */
    public function getParent(): ?Block
    {
        return null;
    }

    /**
     * @param Block $block
     *
     * @return bool
     */
    public function canClose(Block $block): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function canAppend(): bool
    {
        return false;
    }

    /**
     * @param string $content
     *
     * @throws MarkdownException
     */
    public function appendContent(string $content): void
    {
        if (\trim($content) === '') {
            return;
        }
        throw new MarkdownException('Invalid append content: ' . $content);
    }
}
