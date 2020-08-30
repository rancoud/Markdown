<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Markdown;

class BlockquoteTest extends TestCase
{
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
            'Example 199' => [
                'input' => '> # Foo
> bar
> baz',
                'output' => '<blockquote>
<h1>Foo</h1>
<p>bar
baz</p>
</blockquote>',
                'https://github.github.com/gfm/#example-199'
            ],
            'Example 200' => [
                'input' => '># Foo
>bar
> baz',
                'output' => '<blockquote>
<h1>Foo</h1>
<p>bar
baz</p>
</blockquote>',
                'https://github.github.com/gfm/#example-200'
            ],
            'Example 201' => [
                'input' => '   > # Foo
   > bar
 > baz',
                'output' => '<blockquote>
<h1>Foo</h1>
<p>bar
baz</p>
</blockquote>',
                'https://github.github.com/gfm/#example-201'
            ],
            'Example 202' => [
                'input' => '    > # Foo
    > bar
    > baz',
                'output' => '<pre><code>&gt; # Foo
&gt; bar
&gt; baz
</code></pre>',
                'https://github.github.com/gfm/#example-202'
            ],
            'Example 203' => [
                'input' => '> # Foo
> bar
baz',
                'output' => '<blockquote>
<h1>Foo</h1>
<p>bar
baz</p>
</blockquote>',
                'https://github.github.com/gfm/#example-203'
            ],
            'Example 204' => [
                'input' => '> bar
baz
> foo',
                'output' => '<blockquote>
<p>bar
baz
foo</p>
</blockquote>',
                'https://github.github.com/gfm/#example-204'
            ],
            'Example 205' => [
                'input' => '> foo
---',
                'output' => '<blockquote>
<p>foo</p>
</blockquote>
<hr />',
                'https://github.github.com/gfm/#example-205'
            ],
            'Example 206' => [
                'input' => '> - foo
- bar',
                'output' => '<blockquote>
<ul>
<li>foo</li>
</ul>
</blockquote>
<ul>
<li>bar</li>
</ul>',
                'https://github.github.com/gfm/#example-206'
            ],
            'Example 207' => [
                'input' => '>     foo
    bar',
                'output' => '<blockquote>
<pre><code>foo
</code></pre>
</blockquote>
<pre><code>bar
</code></pre>',
                'https://github.github.com/gfm/#example-207'
            ],
            'Example 208' => [
                'input' => '> ```
foo
```',
                'output' => '<blockquote>
<pre><code></code></pre>
</blockquote>
<p>foo</p>
<pre><code></code></pre>',
                'https://github.github.com/gfm/#example-208'
            ],
            'Example 209' => [
                'input' => '> foo
    - bar',
                'output' => '<blockquote>
<p>foo
- bar</p>
</blockquote>',
                'https://github.github.com/gfm/#example-209'
            ],
            'Example 210' => [
                'input' => '>',
                'output' => '<blockquote>
</blockquote>',
                'https://github.github.com/gfm/#example-210'
            ],
            'Example 211' => [
                'input' => '>
>  
> ',
                'output' => '<blockquote>
</blockquote>',
                'https://github.github.com/gfm/#example-211'
            ],
            'Example 212' => [
                'input' => '>
> foo
>  ',
                'output' => '<blockquote>
<p>foo</p>
</blockquote>',
                'https://github.github.com/gfm/#example-212'
            ],
            'Example 213' => [
                'input' => '> foo

> bar',
                'output' => '<blockquote>
<p>foo</p>
</blockquote>
<blockquote>
<p>bar</p>
</blockquote>',
                'https://github.github.com/gfm/#example-213'
            ],
            'Example 214' => [
                'input' => '> foo
> bar',
                'output' => '<blockquote>
<p>foo
bar</p>
</blockquote>',
                'https://github.github.com/gfm/#example-214'
            ],
            'Example 215' => [
                'input' => '> foo
>
> bar',
                'output' => '<blockquote>
<p>foo</p>
<p>bar</p>
</blockquote>',
                'https://github.github.com/gfm/#example-215'
            ],
            'Example 216' => [
                'input' => 'foo
> bar',
                'output' => '<p>foo</p>
<blockquote>
<p>bar</p>
</blockquote>',
                'https://github.github.com/gfm/#example-216'
            ],
            'Example 217' => [
                'input' => '> aaa
***
> bbb',
                'output' => '<blockquote>
<p>aaa</p>
</blockquote>
<hr />
<blockquote>
<p>bbb</p>
</blockquote>',
                'https://github.github.com/gfm/#example-217'
            ],
            'Example 218' => [
                'input' => '> bar
baz',
                'output' => '<blockquote>
<p>bar
baz</p>
</blockquote>',
                'https://github.github.com/gfm/#example-218'
            ],
            'Example 219' => [
                'input' => '> bar

baz',
                'output' => '<blockquote>
<p>bar</p>
</blockquote>
<p>baz</p>',
                'https://github.github.com/gfm/#example-219'
            ],
            'Example 220' => [
                'input' => '> bar
>
baz',
                'output' => '<blockquote>
<p>bar</p>
</blockquote>
<p>baz</p>',
                'https://github.github.com/gfm/#example-220'
            ],
            'Example 221' => [
                'input' => '> > > foo
bar',
                'output' => '<blockquote>
<blockquote>
<blockquote>
<p>foo
bar</p>
</blockquote>
</blockquote>
</blockquote>',
                'https://github.github.com/gfm/#example-221'
            ],
            'Example 222' => [
                'input' => '>>> foo
> bar
>>baz',
                'output' => '<blockquote>
<blockquote>
<blockquote>
<p>foo
bar
baz</p>
</blockquote>
</blockquote>
</blockquote>',
                'https://github.github.com/gfm/#example-222'
            ],
            'Example 223' => [
                'input' => '>     code

>    not code',
                'output' => '<blockquote>
<pre><code>code
</code></pre>
</blockquote>
<blockquote>
<p>not code</p>
</blockquote>',
                'https://github.github.com/gfm/#example-223'
            ]
        ];
    }
}
