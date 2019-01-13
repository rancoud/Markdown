<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\BlankLine;
use Rancoud\Markdown\Markdown;

/**
 * Class BlankLineTest
 */
class BlankLineTest extends TestCase
{
    /**
     * @dataProvider data
     *
     * @param string      $input
     * @param string|null $output
     * @param string|null $render
     */
    public function testIsMe(string $input, ?string $output, ?string $render)
    {
        $m = new Markdown();
        $out = BlankLine::isMe($input);

        if ($output === null) {
            static::assertNull($output, $out);
        } else {
            static::assertEquals($output, get_class($out));
        }

        if ($render !== null) {
            static::assertSame($render, $out->render($m));
        }
    }

    public function data()
    {
        return [
            'blank line #1' => [
                'input' => '',
                'output' => BlankLine::class,
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
    public function testMarkdown(string $input, string $output)
    {
        $m = new Markdown();
        static::assertSame($output, $m->render($input));
    }

    public function dataMarkdown()
    {
        return [
            'Example 190' => [
                'input' => '  

aaa
  

# aaa

  ',
                'output' => '<p>aaa</p>
<h1>aaa</h1>',
                'https://github.github.com/gfm/#example-190'
            ]
        ];
    }
}
