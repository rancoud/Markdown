<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\BlankLine;
use Rancoud\Markdown\Markdown;

class BlankLineTest extends TestCase
{
    /**
     * @dataProvider data
     *
     * @param string      $input
     * @param string|null $output
     * @param string|null $render
     */
    public function testGetBlock(string $input, ?string $output, ?string $render): void
    {
        $m = new Markdown();
        $out = BlankLine::getBlock($input);

        if ($output === null) {
            static::assertNull($out);
        } else {
            static::assertEquals($output, $out->getName());
        }

        if ($render !== null) {
            static::assertSame($render, $out->render($m));
        }
    }

    public function data(): array
    {
        return [
            'blank line #1' => [
                'input' => '',
                'output' => 'BlankLine',
                'render' => ''
            ],
            'blank line #2' => [
                'input' => '-',
                'output' => null,
                'render' => null
            ]
        ];
    }

    /**
     * @dataProvider dataMarkdown
     *
     * @param string $input
     * @param string $output
     */
    public function testMarkdown(string $input, string $output): void
    {
        $m = new Markdown();
        static::assertSame($output, $m->render($input));
    }

    public function dataMarkdown(): array
    {
        return [
            'Example 190' => [
                'input' => '  

aaa
  

# aaa

  ',
                'output' => '<p>aaa</p>
<h1>aaa</h1>',
                'https://github.github.com/gfm/#example-197'
            ]
        ];
    }
}
