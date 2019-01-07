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
        ]
    ];

    public function __construct()
    {
        $this->setDepths();
    }

    public function render(string $content): string
    {
        $this->renderText = "";

        $this->lines = explode("\r\n", $content);
        $this->countLines = count($this->lines);
        for ($this->currentIndex = 0; $this->currentIndex < $this->countLines; $this->currentIndex++) {
            $this->treatLine($this->lines[$this->currentIndex]);
        }

        return $this->renderText;
    }

    protected function treatLine(string $line): void
    {
        if (!$this->isIn('block', 'code')) {
            $line = $this->removeUselessLeadingSpaces($line);
        }

        $this->tokenizer($line);
    }

    protected function removeUselessLeadingSpaces(string $line): string
    {
        if (strspn($line, ' ') < 4) {
            $line = ltrim($line, ' ');
        }

        return $line;
    }

    protected function tokenizer(string $string)
    {
        $str = '';
        $len = mb_strlen($string);

        for ($i = 0; $i < $len; $i++) {
            switch ($string{$i}) {
                case '#':
                    $str = '';
                    break;
                default:
                    $str.= $string{$i};
                    break;
            }


        }
    }

    protected function isIn(string $type, $index): bool
    {
        return $this->getDepth($type, $index) > 0;
    }

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

    protected function setDepth(string $type, string $index): void
    {
        $this->depths[$type] = [];
        $this->depths[$type][$index] = 0;
    }

    protected function addDepth(string $type, string $index): void
    {
        $this->depths[$type][$index]++;
    }

    protected function subDepth(string $type, string $index): void
    {
        $this->depths[$type][$index]--;
    }
}
