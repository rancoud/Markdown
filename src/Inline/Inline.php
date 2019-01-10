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
     *
     * @return string
     */
    public static function render(string $content): string;
}