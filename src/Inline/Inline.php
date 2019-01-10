<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Inline;

/**
 * Interface Inline
 */
interface Inline
{
    /**
     * @param string $content
     */
    public static function scanContent(string $content): void;
}