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
    public static function isLeaf(): bool
    {
        return true;
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
        throw new \Exception('Invalid append block');
    }

    /**
     * @return string
     */
    public function getLine(): ?string
    {
        return null;
    }
}
