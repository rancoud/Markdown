<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;
use Rancoud\Markdown\MarkdownException;

/**
 * Class FencedCode.
 */
class FencedCode implements Block
{
    protected ?Block $parent = null;
    protected array $content = [];

    /**
     * FencedCode constructor.
     *
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->content[] = $content;
    }

    /**
     * @param string $line
     *
     * @return Block|null
     */
    public static function getBlock(string $line): ?Block
    {
        if (\strncmp($line, '```', 3) === 0) {
            return new self(\mb_substr($line, 4) . "\n");
        }

        if (\strncmp($line, '~~~', 3) === 0) {
            return new self(\mb_substr($line, 4) . "\n");
        }

        return null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'FencedCode';
    }

    /**
     * @return bool
     */
    public function isContainer(): bool
    {
        return false;
    }

    /**
     * @param Markdown $markdown
     *
     * @return string
     */
    public function render(Markdown $markdown): string
    {
        $content = \implode("\n", $this->content);
        $content = \htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        return '<pre><code>' . $content . '</code></pre>';
    }

    /**
     * @param Block $block
     *
     * @throws MarkdownException
     */
    public function appendBlock(Block $block): void
    {
        throw new MarkdownException('Invalid append block: ' . $block->getName());
    }

    /**
     * @return string
     */
    public function getLine(): ?string
    {
        return null;
    }

    /**
     * @return Block|null
     */
    public function getParent(): ?Block
    {
        return $this->parent;
    }

    /**
     * @param Block $block
     */
    public function setParent(Block $block): void
    {
        $this->parent = $block;
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
        return true;
    }

    /**
     * @param string $content
     */
    public function appendContent(string $content): void
    {
        $this->content[] = $content;
    }
}
