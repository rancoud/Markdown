<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\LinkReferenceDefinition;
use Rancoud\Markdown\Markdown;

class LinkReferenceDefinitonTest extends TestCase
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
        $out = LinkReferenceDefinition::getBlock($input);

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
            'link reference definition' => [
                'input' => '[foo]: /url "title"[foo]',
                'output' => LinkReferenceDefinition::class,
                'render' => '<p><a href="/url" title="title">foo</a></p>'
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
            'Example 159' => [
                'input' => '[foo]: /url "title"

[foo]',
                'output' => '<p><a href="/url" title="title">foo</a></p>',
                'https://github.github.com/gfm/#example-159'
            ],
            'Example 160' => [
                'input' => '   [foo]: 
      /url  
           \'the title\'  

[foo]',
                'output' => '<p><a href="/url" title="the title">foo</a></p>',
                'https://github.github.com/gfm/#example-160'
            ],
            'Example 161' => [
                'input' => '[Foo*bar\]]:my_(url) \'title (with parens)\'

[Foo*bar\]]',
                'output' => '<p><a href="my_(url)" title="title (with parens)">Foo*bar]</a></p>',
                'https://github.github.com/gfm/#example-161'
            ],
            'Example 162' => [
                'input' => '[Foo bar]:
<my url>
\'title\'

[Foo bar]',
                'output' => '<p><a href="my%20url" title="title">Foo bar</a></p>',
                'https://github.github.com/gfm/#example-162'
            ],
            'Example 163' => [
                'input' => '[foo]: /url \'
title
line1
line2
\'

[foo]',
                'output' => '<p><a href="/url" title="
title
line1
line2
">foo</a></p>',
                'https://github.github.com/gfm/#example-163'
            ],
            'Example 164' => [
                'input' => '[foo]: /url \'title

with blank line\'

[foo]',
                'output' => '<p>[foo]: /url \'title</p>
<p>with blank line\'</p>
<p>[foo]</p>',
                'https://github.github.com/gfm/#example-164'
            ],
            'Example 165' => [
                'input' => '[foo]:
/url

[foo]',
                'output' => '<p><a href="/url">foo</a></p>',
                'https://github.github.com/gfm/#example-165'
            ],
            'Example 166' => [
                'input' => '[foo]:

[foo]',
                'output' => '<p>[foo]:</p>
<p>[foo]</p>',
                'https://github.github.com/gfm/#example-166'
            ],
            'Example 167' => [
                'input' => '[foo]: /url\bar\*baz "foo\"bar\baz"

[foo]',
                'output' => '<p><a href="/url%5Cbar*baz" title="foo&quot;bar\baz">foo</a></p>',
                'https://github.github.com/gfm/#example-167'
            ],
            'Example 168' => [
                'input' => '[foo]

[foo]: url',
                'output' => '<p><a href="url">foo</a></p>',
                'https://github.github.com/gfm/#example-168'
            ],
            'Example 169' => [
                'input' => '[foo]

[foo]: first
[foo]: second',
                'output' => '<p><a href="first">foo</a></p>',
                'https://github.github.com/gfm/#example-169'
            ],
            'Example 170' => [
                'input' => '[FOO]: /url

[Foo]',
                'output' => '<p><a href="/url">Foo</a></p>',
                'https://github.github.com/gfm/#example-170'
            ],
            'Example 171' => [
                'input' => '[ΑΓΩ]: /φου

[αγω]',
                'output' => '<p><a href="/%CF%86%CE%BF%CF%85">αγω</a></p>',
                'https://github.github.com/gfm/#example-171'
            ],
            'Example 172' => [
                'input' => '[foo]: /url',
                'output' => '',
                'https://github.github.com/gfm/#example-172'
            ],
            'Example 173' => [
                'input' => '[
foo
]: /url
bar',
                'output' => '<p>bar</p>',
                'https://github.github.com/gfm/#example-173'
            ],
            'Example 174' => [
                'input' => '[foo]: /url "title" ok',
                'output' => '<p>[foo]: /url &quot;title&quot; ok</p>',
                'https://github.github.com/gfm/#example-174'
            ],
            'Example 175' => [
                'input' => '[foo]: /url
"title" ok',
                'output' => '<p>&quot;title&quot; ok</p>',
                'https://github.github.com/gfm/#example-175'
            ],
            'Example 176' => [
                'input' => '    [foo]: /url "title"

[foo]',
                'output' => '<pre><code>[foo]: /url &quot;title&quot;
</code></pre>
<p>[foo]</p>',
                'https://github.github.com/gfm/#example-176'
            ],
            'Example 177' => [
                'input' => '```
[foo]: /url
```

[foo]',
                'output' => '<pre><code>[foo]: /url
</code></pre>
<p>[foo]</p>',
                'https://github.github.com/gfm/#example-177'
            ],
            'Example 178' => [
                'input' => 'Foo
[bar]: /baz

[bar]',
                'output' => '<p>Foo
[bar]: /baz</p>
<p>[bar]</p>',
                'https://github.github.com/gfm/#example-178'
            ],
            'Example 179' => [
                'input' => '# [Foo]
[foo]: /url
> bar',
                'output' => '<h1><a href="/url">Foo</a></h1>
<blockquote>
<p>bar</p>
</blockquote>',
                'https://github.github.com/gfm/#example-179'
            ],
            'Example 180' => [
                'input' => '[foo]: /foo-url "foo"
[bar]: /bar-url
  "bar"
[baz]: /baz-url

[foo],
[bar],
[baz]',
                'output' => '<p><a href="/foo-url" title="foo">foo</a>,
<a href="/bar-url" title="bar">bar</a>,
<a href="/baz-url">baz</a></p>',
                'https://github.github.com/gfm/#example-180'
            ],
            'Example 181' => [
                'input' => '[foo]

> [foo]: /url',
                'output' => '<p><a href="/url">foo</a></p>
<blockquote>
</blockquote>',
                'https://github.github.com/gfm/#example-181'
            ]
        ];
    }
}
