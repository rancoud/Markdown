<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

/**
 * Class Heading
 *
 * @package Rancoud\Markdown
 */
class Heading implements Block
{
    protected $headerLevel = 0;
    protected $title = '';

    public function __construct(int $headerLevel, string $title)
    {
        $this->headerLevel = $headerLevel;
        $this->title = $title;
    }

    public static function isLeaf(): bool
    {
        return true;
    }

    public static function isMe(string $line): ?Block
    {
        $title = null;
        $headerLevelFound = 0;

        for ($headerLevel = 6; $headerLevel > 0; --$headerLevel) {
            $closedHeaderMark = \str_repeat('#', $headerLevel);
            if (\strncmp($closedHeaderMark . ' ', $line, $headerLevel + 1) === 0) {
                $title = \trim(\mb_substr($line, $headerLevel + 1));
                $headerLevelFound = $headerLevel;
                break;
            } elseif ($closedHeaderMark === $line) {
                return new Heading($headerLevel, '');
            }
        }

        if ($headerLevelFound > 0 && $title[\mb_strlen($title) - 1] === '#') {
            $closedHeaderMark = \str_repeat('#', $headerLevelFound);
            if (\mb_substr($title, -($headerLevelFound + 1)) === $closedHeaderMark) {
                $title = \trim(\mb_substr($title, 0, \mb_strlen($title) - ($headerLevelFound + 1)));
            }
        }

        if ($title !== null) {
            return new Heading($headerLevel, '');
        }

        return null;
    }

    public function render(): string
    {
        return '<h' . $this->headerLevel . '>' . $this->title . '</h' . $this->headerLevel . '>';
    }
}