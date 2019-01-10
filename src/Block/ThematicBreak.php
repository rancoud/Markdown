<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

/**
 * Class ThematicBreak
 *
 * @package Rancoud\Markdown
 */
class ThematicBreak implements Block
{
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
    public static function isLeaf(): bool
    {
        return true;
    }

    /**
     * @param string $line
     *
     * @return Block
     */
    public static function isMe(string $line): ?Block
    {
        if (!in_array($line[0], static::$authorizedCharacters, true)) {
            return null;
        }

        if ($line === '***') {
            return new ThematicBreak('*');
        }

        if ($line === '---') {
            return new ThematicBreak('-');
        }

        if ($line === '___') {
            return new ThematicBreak('_');
        }

        return null;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return '<hr />';
    }
}