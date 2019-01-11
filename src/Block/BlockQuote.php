<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Class BlockQuote.
 */
class BlockQuote implements Block
{
    protected $line;

    /**
     * @var Block[]
     */
    protected $blocks = [];

    /**
     * BlockQuote constructor.
     *
     * @param string $line
     */
    public function __construct(string $line)
    {
        $this->line = $line;
    }

    /**
     * @return bool
     */
    public static function isLeaf(): bool
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
        if ($line[0] === '>') {
            return new self(\mb_substr($line, 1));
        }

        return null;
    }

    /**
     * @param Markdown $markdown
     *
     * @return string
     */
    public function render(Markdown $markdown): string
    {
        $content = '';

        foreach ($this->blocks as $block) {
            $content .= $block->render($markdown);
        }

        return '<blockquote>' . $content . '</blockquote>';
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
        return $this->line;
    }
}
