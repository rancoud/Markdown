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

    public function __construct()
    {
        //
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
        if (!$this->isInCode()) {
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

    protected function isInCode(): bool
    {
        return false;
    }
}
