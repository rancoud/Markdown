<?php

declare(strict_types=1);

namespace Rancoud\Markdown;

/**
 * Class Markdown.
 */
class Markdown
{
    protected $renderText = '';

    public function __construct()
    {
        //
    }

    public function render(string $content): string
    {
        $this->renderText = "";

        $lines = explode("\r\n", $content);
        $countLines = count($lines);
        for ($i = 0; $i < $countLines; $i++) {
            $this->treatLine($lines[$i]);
        }

        return $this->renderText;
    }

    protected function treatLine(string $line): void
    {
        $this->tokenizer($line);
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
}
