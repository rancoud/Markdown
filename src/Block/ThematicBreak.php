<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;
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
     * @return Block|null
     */
    public static function isMe(string $line): ?Block
    {
        if (strncmp($line, '    ', 4) === 0) {
            return null;
        }

        $line = str_replace(' ', '', $line);

        if (!in_array($line[0], static::$authorizedCharacters, true)) {
            return null;
        }

        $character = $line[0];

        $uniqueCharacters = count_chars($line, 3);

        if ($uniqueCharacters === $character) {
            return new ThematicBreak($character);
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
}