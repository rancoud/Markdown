<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Class IndentedCode.
 */
class IndentedCode implements Block
{
    protected $parent = null;
    protected $content = [];

    /**
     * IndentedCode constructor.
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
        if (\strncmp($line, '    ', 4) === 0) {
            return new self(mb_substr($line, 4) . "\r\n");
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
        $content = \implode("\r\n", $this->content);
        $content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');

        return '<pre><code>' . $content . '</code></pre>';
    }

    /**
     * @param Block $block
     *
     * @throws \Exception
     */
    public function appendBlock(Block $block): void
    {
        throw new \Exception('Invalid append block: ' . $block);
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
        $this->content[] = $content;
    }
}
