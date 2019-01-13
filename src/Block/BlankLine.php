<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Class BlankLine.
 */
class BlankLine implements Block
{
    /**
     * @return bool
     */
    public function isContainer(): bool
    {
        return false;
    }

    /**
     * @param string $line
     *
     * @return Block|null
     */
    public static function isMe(string $line): ?Block
    {
        return (\trim($line) === '') ? new self() : null;
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
     *
     * @throws \Exception
     */
    public function appendBlock(Block $block): void
    {
        throw new \Exception('Invalid append block ' . $block);
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
    public function setParent(Block $block) : void
    {
        return;
    }

    /**
     * @return Block|null
     */
    public function getParent() : ?Block
    {
        return null;
    }

    /**
     * @param Block $block
     *
     * @return bool
     */
    public function canClose(Block $block) : bool
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
     * @throws \Exception
     */
    public function appendContent(string $content): void
    {
        if (trim($content) === '') {
            return;
        }
        throw new \Exception('Invalid append content: ' . $content);
    }
}
