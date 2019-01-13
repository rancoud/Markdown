<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Class ThematicBreak.
 */
class ThematicBreak implements Block
{
    protected $parent = null;
    protected static $authorizedCharacters = ['*', '-', '_'];
    protected $charactersUsed = null;

    /**
     * ThematicBreak constructor.
     *
     * @param string $charactersUsed
     */
    public function __construct(string $charactersUsed)
    {
        $this->charactersUsed = $charactersUsed;
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
            return null;
        }

        $line = \str_replace(' ', '', $line);

        if ($line === '') {
            return null;
        }

        if (!\in_array($line[0], static::$authorizedCharacters, true)) {
            return null;
        }

        $character = $line[0];

        $uniqueCharacters = \count_chars($line, 3);

        if ($uniqueCharacters === $character) {
            return new self($character);
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
        return '<hr />';
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
        return false;
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
