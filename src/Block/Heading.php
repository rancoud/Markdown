<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Block;

use Rancoud\Markdown\Markdown;

/**
 * Class Heading
 *
 * @package Rancoud\Markdown
 */
class Heading implements Block
{
    protected $headerLevel = 0;
    protected $title = '';

    /**
     * Heading constructor.
     *
     * @param int    $headerLevel
     * @param string $title
     */
    public function __construct(int $headerLevel, string $title)
    {
        $this->headerLevel = $headerLevel;
        $this->title = $title;
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
        $title = null;
        $headerLevelFound = 0;

        if (strncmp($line, '    ', 4) === 0) {
            return null;
        }

        $line = trim($line);

        for ($headerLevel = 6; $headerLevel > 0; --$headerLevel) {
            $headerSigns = \str_repeat('#', $headerLevel);
            if (\strncmp($headerSigns . ' ', $line, $headerLevel + 1) === 0) {
                $title = \mb_substr($line, $headerLevel + 1);
                $headerLevelFound = $headerLevel;
                break;
            } elseif ($headerSigns === $line) {
                return new Heading($headerLevel, '');
            }
        }

        if ($title !== null) {
            $title = trim(Heading::detectClosedHeaderSigns($headerLevelFound, $title));
            return new Heading($headerLevel, $title);
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
        $title = $markdown->renderInline($this->title);
        return '<h' . $this->headerLevel . '>' . $title . '</h' . $this->headerLevel . '>';
    }

    /**
     * @param int    $headerLevelFound
     * @param string $title
     *
     * @return string
     */
    protected static function detectClosedHeaderSigns(int $headerLevelFound, string $title): string
    {
        if ($headerLevelFound === 0 || mb_substr($title, \mb_strlen($title) - 1, 1) !== '#') {
            return $title;
        }

        $reverseTitle = strrev($title);
        $positionFirstSpace = mb_strpos($reverseTitle, ' ');
        if ($positionFirstSpace === false) {
            if (count_chars($title, 3) === '#') {
                return '';
            }
            
            return $title;
        }

        $closedHeaderSigns = mb_substr($reverseTitle, 0, $positionFirstSpace);
        $uniqueCharacters = count_chars($closedHeaderSigns, 3);
        if ($uniqueCharacters === '#') {
            $title = strrev(mb_substr($reverseTitle, $positionFirstSpace));
        } elseif ($uniqueCharacters === '#\\') {
            $closedHeaderSignsCorrected = str_replace('\\', '', $closedHeaderSigns);
            $reverseTitle = str_replace($closedHeaderSigns, $closedHeaderSignsCorrected, $reverseTitle);
            $title = strrev($reverseTitle);
        }

        return $title;
    }
}