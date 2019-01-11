<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Class Paragraph.
 */
class Paragraph implements Block
{
    protected $content = [];

    /**
     * Paragraph constructor.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content[] = $content;
    }

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
        return new self($line);
    }

    /**
     * @param Markdown $markdown
     *
     * @return string
     */
    public function render(Markdown $markdown): string
    {
        $content = $markdown->renderInline(\implode("\r\n", $this->content));

        return '<p>' . $content . '</p>';
    }

    /**
     * @param string $line
     */
    public function appendContent(string $line): void
    {
        $this->content[] = $line;
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
