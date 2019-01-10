<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Inline;

/**
 * Class Emphasis
 */
class Emphasis implements Inline
{
    /**
     * @param string $content
     *
     * @return string
     */
    public static function render(string $content): string
    {
        return preg_replace('/\*([^\*]+)\*/', '<em>$1</em>', $content);
    }
}