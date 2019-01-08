<?php

declare(strict_types=1);

namespace Rancoud\Markdown;

/**
 * Class Markdown.
 */
class Markdown
{
    protected $renderText = '';
    protected $lines = [];
    protected $countLines = 0;
    protected $currentIndex = 0;
    protected $countRunes = 0;
    protected $currentRune = 0;

    protected $depths = [];
    protected $types = [
        'block' => [
            'code',
            'table',
            'blockquote'
        ],
        'inline' => [
            'bold',
            'italic',
            'strike',
            'link',
            'image',
            'simple_code',
            'double_code'
        ]
    ];

    public function __construct()
    {
        $this->setDepths();
    }

    public function render(string $content): string
    {
        $this->renderText = '';

        $this->lines = \preg_split('/\R/', $content);
        $this->countLines = \count($this->lines);
        for ($this->currentIndex = 0; $this->currentIndex < $this->countLines; ++$this->currentIndex) {
            $this->treatLine($this->lines[$this->currentIndex]);
        }

        return $this->renderText;
    }

    protected function treatLine(string $line): void
    {
        if (!$this->isIn('block', 'code')) {
            $line = $this->removeUselessLeadingSpaces($line);
        }

        $header = $this->handleHeader($line);
        if ($header !== null) {
            $this->renderText .= $header;
        } else {
            $this->tokenizer($line);
        }

        $this->renderText .= "\r\n";
    }

    protected function removeUselessLeadingSpaces(string $line): string
    {
        if (\strspn($line, ' ') < 4) {
            $line = \ltrim($line, ' ');
        }

        return $line;
    }

    protected function tokenizer(string $string)
    {
        $this->countRunes = \mb_strlen($string);

        for ($this->currentRune = 0; $this->currentRune < $this->countRunes; ++$this->currentRune) {
            $nextOne = $string[$this->currentRune + 1] ?? null;
            $nextTwo = $string[$this->currentRune + 2] ?? null;
            switch ($string[$this->currentRune]) {
                case '`':
                    $this->renderText .= $this->handleCode($nextOne, $nextTwo);
                    break;
                case '#':
                    $this->renderText .= '#';
                    break;
                case '*':
                    $this->renderText .= '*';
                    break;
                case '_':
                    $this->renderText .= '_';
                    break;
                case '~':
                    $this->renderText .= '~';
                    break;
                default:
                    $this->renderText .= $string[$this->currentRune];
                    break;
            }
        }

        if (\mb_strrpos($this->renderText, '  ') === \mb_strlen($this->renderText) - 2) {
            $this->renderText = \mb_substr($this->renderText, 0, \mb_strlen($this->renderText) - 2) . '<br />';
        }
    }

    // TODO : block level and multiple quotes patterns ```` ````
    protected function handleCode(?string $nextOne, ?string $nextTwo): string
    {
        $isDoubleTick = false;
        if ($nextOne !== null && $nextOne === '`') {
            $isDoubleTick = true;
            ++$this->currentRune;

            if ($this->isIn('inline', 'simple_code')) {
                return '``';
            }

            // Manage:
            // ``sth sth``
            if (!$this->isIn('inline', 'double_code')) {
                $this->addDepth('inline', 'double_code');

                if ($nextTwo === ' ') {
                    ++$this->currentRune;
                }

                return '<code>';
            }
            $this->subDepth('inline', 'double_code');

            if ($this->renderText[\mb_strlen($this->renderText) - 1] === ' ') {
                $this->renderText = \mb_substr($this->renderText, 0, \mb_strlen($this->renderText) - 1);
            }

            return '</code>';
        }
        // Manage:
        // `` ` ``
        if ($this->isIn('inline', 'double_code')) {
            return '`';
        }

        // Manage:
        // `sth `` sth`
        if ($isDoubleTick && $this->isIn('inline', 'simple_code')) {
            return '``';
        }

        /* Manage:
         * a `code span`
         * `this is also a codespan` trailing text
         * `and look at this one!`
         * */
        if (!$this->isIn('inline', 'simple_code')) {
            $this->addDepth('inline', 'simple_code');

            return '<code>';
        }
        $this->subDepth('inline', 'simple_code');

        return '</code>';
    }

    protected function handleHeader(string $line): ?string
    {
        $output = null;
        $headerLevelFound = 0;

        for ($headerLevel = 6; $headerLevel > 0; --$headerLevel) {
            $closedHeaderMark = \str_repeat('#', $headerLevel);
            if (\strncmp($closedHeaderMark . ' ', $line, $headerLevel + 1) === 0) {
                $output = '<h' . $headerLevel . '>' . \trim(\mb_substr($line, $headerLevel + 1)) . '</h' . $headerLevel . '>';
                $headerLevelFound = $headerLevel;
                break;
            } elseif ($closedHeaderMark === $line) {
                return '<h' . $headerLevel . '></h' . $headerLevel . '>';
            }
        }

        if ($headerLevelFound > 0 && $output[\mb_strlen($output) - 6] === '#') {
            $closedHeaderMark = \str_repeat('#', $headerLevelFound);
            if (\mb_substr($output, -($headerLevelFound + 5)) === ($closedHeaderMark . '</h' . $headerLevelFound . '>')) {
                $output = \trim(\mb_substr($output, 0, \mb_strlen($output) - ($headerLevelFound + 5))) . '</h' . $headerLevelFound . '>';
            }
        }

        return $output;
    }

    //region Depth Managing

    /**
     * @param string $type
     * @param string $index
     *
     * @return bool
     */
    protected function isIn(string $type, string $index): bool
    {
        return $this->getDepth($type, $index) > 0;
    }

    /**
     * @param string $type
     * @param string $index
     *
     * @return int
     */
    protected function getDepth(string $type, string $index): int
    {
        return $this->depths[$type][$index];
    }

    protected function setDepths(): void
    {
        foreach ($this->types as $type => $indexes) {
            foreach ($indexes as $index) {
                $this->setDepth($type, $index);
            }
        }
    }

    /**
     * @param string $type
     * @param string $index
     */
    protected function setDepth(string $type, string $index): void
    {
        if (!isset($this->depths[$type])) {
            $this->depths[$type] = [];
        }

        $this->depths[$type][$index] = 0;
    }

    /**
     * @param string $type
     * @param string $index
     */
    protected function addDepth(string $type, string $index): void
    {
        ++$this->depths[$type][$index];
    }

    /**
     * @param string $type
     * @param string $index
     */
    protected function subDepth(string $type, string $index): void
    {
        --$this->depths[$type][$index];
    }

    //endregion
}
