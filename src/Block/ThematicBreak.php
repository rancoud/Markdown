<?php

declare(strict_types=1);

namespace Rancoud\Markdown;

class ThematicBreak implements Block
{
    static protected $authorizedCharacters = ['*', '-', '_'];

    public static function isLeaf(): bool
    {
        return true;
    }

    public static function isMe(string $line): Block
    {
        if (!in_array($line[0], static::$authorizedCharacters, true)) {
            return null;
        }

        if ($line === '***') {
            return new ThematicBreak();
        }

        if ($line === '---') {
            return new ThematicBreak();
        }

        if ($line === '___') {
            return new ThematicBreak();
        }

        return null;
    }

    public function render(): string
    {
        return '<hr />';
    }
}