<?php

declare(strict_types=1);

namespace Rancoud\Markdown;

interface Block
{
    public static function isLeaf(): bool;
    public static function isMe(string $line): ?Block;
    public function render(): string;
}