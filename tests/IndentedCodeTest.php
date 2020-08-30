<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\IndentedCode;
use Rancoud\Markdown\Markdown;

class IndentedCodeTest extends TestCase
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
        $out = IndentedCode::getBlock($input);

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
            'blank line #1' => [
                'input' => '    foo  ',
                'output' => IndentedCode::class,
                'render' => '<pre><code>foo  
</code></pre>',
                'https://github.github.com/gfm/#example-87'
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
            'Example 76' => [
                'input' => '    a simple
      indented code block',
                'output' => '<pre><code>a simple
  indented code block
</code></pre>',
                'https://github.github.com/gfm/#example-76'
            ],
            'Example 77' => [
                'input' => '  - foo

    bar',
                'output' => '<ul>
<li>
<p>foo</p>
<p>bar</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-77'
            ],
            'Example 78' => [
                'input' => '1.  foo

    - bar',
                'output' => '<ol>
<li>
<p>foo</p>
<ul>
<li>bar</li>
</ul>
</li>
</ol>',
                'https://github.github.com/gfm/#example-78'
            ],
            'Example 79' => [
                'input' => '    <a/>
    *hi*

    - one',
                'output' => '<pre><code>&lt;a/&gt;
*hi*

- one
</code></pre>',
                'https://github.github.com/gfm/#example-79'
            ],
            'Example 80' => [
                'input' => '    chunk1

    chunk2
  
 
 
    chunk3',
                'output' => '<pre><code>chunk1

chunk2



chunk3
</code></pre>',
                'https://github.github.com/gfm/#example-80'
            ],
            'Example 81' => [
                'input' => '    chunk1
      
      chunk2',
                'output' => '<pre><code>chunk1
  
  chunk2
</code></pre>',
                'https://github.github.com/gfm/#example-81'
            ],
            'Example 82' => [
                'input' => 'Foo
    bar',
                'output' => '<p>Foo
bar</p>',
                'https://github.github.com/gfm/#example-82'
            ],
            'Example 83' => [
                'input' => '    foo
bar',
                'output' => '<pre><code>foo
</code></pre>
<p>bar</p>',
                'https://github.github.com/gfm/#example-83'
            ],
            'Example 84' => [
                'input' => '# Heading
    foo
Heading
------
    foo
----',
                'output' => '<h1>Heading</h1>
<pre><code>foo
</code></pre>
<h2>Heading</h2>
<pre><code>foo
</code></pre>
<hr />',
                'https://github.github.com/gfm/#example-84'
            ],
            'Example 85' => [
                'input' => '        foo
    bar',
                'output' => '<pre><code>    foo
bar
</code></pre>',
                'https://github.github.com/gfm/#example-85'
            ],
            'Example 86' => [
                'input' => '
    
    foo
    ',
                'output' => '<pre><code>foo
</code></pre>',
                'https://github.github.com/gfm/#example-86'
            ]
        ];
    }
}
