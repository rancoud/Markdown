<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\Paragraph;
use Rancoud\Markdown\Markdown;

/**
 * Class ParagraphTest
 */
class ParagraphTest extends TestCase
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
        $out = Paragraph::getBlock($input);

        if ($output === null) {
            static::assertNull($out);
        } else {
            static::assertEquals($output, get_class($out));
        }

        if ($render !== null) {
            static::assertSame($render, $out->render($m));
        }
    }

    public function data(): array
    {
        return [
            'paragraph' => [
                'input' => 'a',
                'output' => Paragraph::class,
                'render' => '<p>a</p>'
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
            'Example 182' => [
                'input' => 'aaa

bbb',
                'output' => '<p>aaa</p>
<p>bbb</p>',
                'https://github.github.com/gfm/#example-182'
            ],
            'Example 183' => [
                'input' => 'aaa
bbb

ccc
ddd',
                'output' => '<p>aaa
bbb</p>
<p>ccc
ddd</p>',
                'https://github.github.com/gfm/#example-183'
            ],
            'Example 184' => [
                'input' => 'aaa


bbb',
                'output' => '<p>aaa</p>
<p>bbb</p>',
                'https://github.github.com/gfm/#example-184'
            ],
            'Example 185' => [
                'input' => '  aaa
 bbb',
                'output' => '<p>aaa
bbb</p>',
                'https://github.github.com/gfm/#example-185'
            ],
            'Example 186' => [
                'input' => 'aaa
             bbb
                                       ccc',
                'output' => '<p>aaa
bbb
ccc</p>',
                'https://github.github.com/gfm/#example-186'
            ],
            'Example 187' => [
                'input' => '   aaa
bbb',
                'output' => '<p>aaa
bbb</p>',
                'https://github.github.com/gfm/#example-187'
            ],
            'Example 188' => [
                'input' => '    aaa
bbb',
                'output' => '<pre><code>aaa
</code></pre>
<p>bbb</p>',
                'https://github.github.com/gfm/#example-188'
            ],
            'Example 189' => [
                'input' => 'aaa     
bbb     ',
                'output' => '<p>aaa<br />
bbb</p>',
                'https://github.github.com/gfm/#example-189'
            ]
        ];
    }
}
