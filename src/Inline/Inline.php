<?php

declare(strict_types=1);

namespace Rancoud\Markdown;

interface Inline
{
    public static function scanContent(string $content): void;
}