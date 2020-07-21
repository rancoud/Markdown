<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\ThematicBreak;
use Rancoud\Markdown\Markdown;

/**
 * Class ThematicBreakTest
 */
class ThematicBreakTest extends TestCase
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
        $out = ThematicBreak::getBlock($input);

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
            'correct ***' => [
                'input' => '***',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-13'
            ],
            'correct ---' => [
                'input' => '---',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-13'
            ],
            'correct ___' => [
                'input' => '___',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-13'
            ],
            'wrong characters +++' => [
                'input' => '+++',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-14'
            ],
            'wrong characters ===' => [
                'input' => '===',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-15'
            ],
            'not enough characters --' => [
                'input' => '--',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-16'
            ],
            'not enough characters ==' => [
                'input' => '**',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-16'
            ],
            'not enough characters __' => [
                'input' => '__',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-16'
            ],
            'one spaces indent allowed' => [
                'input' => ' ***',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-17'
            ],
            'two spaces indent allowed' => [
                'input' => '  ***',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-18'
            ],
            'three spaces indent allowed' => [
                'input' => '   ***',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-18'
            ],
            'four spaces too many' => [
                'input' => '    ***',
                'output' => null,
                'render' => null
            ],
            'more than three characters may be used' => [
                'input' => '_____________________________________',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-20'
            ],
            'spaces allowed between characters #1' => [
                'input' => ' - - -',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-21'
            ],
            'spaces allowed between characters #2' => [
                'input' => ' **  * ** * ** * **',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-22'
            ],
            'spaces allowed between characters #3' => [
                'input' => '-     -      -      -',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-23'
            ],
            'spaces allowed at the end' => [
                'input' => '- - - -    ',
                'output' => 'ThematicBreak',
                'render' => '<hr />',
                'https://github.github.com/gfm/#example-24'
            ],
            'no other characters may occur in the line #1' => [
                'input' => '_ _ _ _ a',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-25'
            ],
            'no other characters may occur in the line #2' => [
                'input' => 'a------',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-25'
            ],
            'no other characters may occur in the line #3' => [
                'input' => '---a---',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-25'
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
            'Example 13' => [
                'input' => '***
---
___',
                'output' => '<hr />
<hr />
<hr />',
                'https://github.github.com/gfm/#example-13'
            ],
            'Example 16' => [
                'input' => '--
**
__',
                'output' => '<p>--
**
__</p>',
                'https://github.github.com/gfm/#example-16'
            ],
            'Example 17' => [
                'input' => ' ***
  ***
   ***',
                'output' => '<hr />
<hr />
<hr />',
                'https://github.github.com/gfm/#example-16'
            ],
            'Example 19' => [
                'input' => 'Foo
    ***',
                'output' => '<p>Foo
***</p>',
                'https://github.github.com/gfm/#example-19'
            ],
            'Example 25' => [
                'input' => '_ _ _ _ a

a------

---a---',
                'output' => '<p>_ _ _ _ a</p>
<p>a------</p>
<p>---a---</p>',
                'https://github.github.com/gfm/#example-25'
            ],
            'Example 26' => [
                'input' => ' *-*',
                'output' => '<p><em>-</em></p>',
                'https://github.github.com/gfm/#example-26'
            ],
            'Example 27' => [
                'input' => '- foo
***
- bar',
                'output' => '<ul>
<li>foo</li>
</ul>
<hr />
<ul>
<li>bar</li>
</ul>',
                'https://github.github.com/gfm/#example-27'
            ],
            'Example 28' => [
                'input' => 'Foo
***
bar',
                'output' => '<p>Foo</p>
<hr />
<p>bar</p>',
                'https://github.github.com/gfm/#example-28'
            ],
            'Example 29' => [
                'input' => 'Foo
---
bar',
                'output' => '<h2>Foo</h2>
<p>bar</p>',
                'https://github.github.com/gfm/#example-29'
            ],
            'Example 30' => [
                'input' => '* Foo
* * *
* Bar',
                'output' => '<ul>
<li>Foo</li>
</ul>
<hr />
<ul>
<li>Bar</li>
</ul>',
                'https://github.github.com/gfm/#example-30'
            ],
            'Example 31' => [
                'input' => '- Foo
- * * *',
                'output' => '<ul>
<li>Foo</li>
<li>
<hr />
</li>
</ul>',
                'https://github.github.com/gfm/#example-31'
            ]
        ];
    }
}
