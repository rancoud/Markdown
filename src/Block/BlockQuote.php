<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Class BlockQuote.
 */
class BlockQuote implements Block
{
    protected $parent = null;
    protected $line;
    protected $level;

    /**
     * @var Block[]
     */
    protected $blocks = [];

    /**
     * BlockQuote constructor.
     *
     * @param string $line
     * @param int    $level
     */
    public function __construct(string $line, int $level = 1)
    {
        $this->line = $line;
        $this->level = $level;
    }

    /**
     * @return bool
     */
    public function isContainer(): bool
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
        // TODO: WRONG just for testing
        if (strncmp('>>>', $line[0], 3) === 0) {
            return new self(\mb_substr($line, 3), 3);
        }

        if (strncmp('>>', $line[0], 2) === 0) {
            return new self(\mb_substr($line, 2), 2);
        }

        if (strncmp('>', $line[0], 1) === 0) {
            return new self(\mb_substr($line, 1), 1);
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

    /**
     * @return Block|null
     */
    public function getParent() : ?Block
    {
        return $this->parent;
    }

    /**
     * @param Block $block
     */
    public function setParent(Block $block) : void
    {
        $this->parent = $block;
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
        return true;
    }

    /**
     * @param string $content
     *
     * @throws \Exception
     */
    public function appendContent(string $content): void
    {
        throw new \Exception('Invalid append content');
    }
}
