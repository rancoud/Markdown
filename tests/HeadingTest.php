<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\Heading;
use Rancoud\Markdown\Markdown;

/**
 * Class HeadingTest
 */
class HeadingTest extends TestCase
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
        $out = Heading::getBlock($input);

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
            'simple heading #1' => [
                'input' => '# foo',
                'output' => Heading::class,
                'render' => '<h1>foo</h1>',
                'https://github.github.com/gfm/#example-32'
            ],
            'simple heading #2' => [
                'input' => '## foo',
                'output' => Heading::class,
                'render' => '<h2>foo</h2>',
                'https://github.github.com/gfm/#example-32'
            ],
            'simple heading #3' => [
                'input' => '### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>',
                'https://github.github.com/gfm/#example-32'
            ],
            'simple heading #4' => [
                'input' => '#### foo',
                'output' => Heading::class,
                'render' => '<h4>foo</h4>',
                'https://github.github.com/gfm/#example-32'
            ],
            'simple heading #5' => [
                'input' => '##### foo',
                'output' => Heading::class,
                'render' => '<h5>foo</h5>',
                'https://github.github.com/gfm/#example-32'
            ],
            'simple heading #6' => [
                'input' => '###### foo',
                'output' => Heading::class,
                'render' => '<h6>foo</h6>',
                'https://github.github.com/gfm/#example-32'
            ],
            'excess # not a heading' => [
                'input' => '####### foo',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-33'
            ],
            'no space after # #1' => [
                'input' => '#5 bolt',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-34'
            ],
            'no space after # #2' => [
                'input' => '#hashtag',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-34'
            ],
            'no escape allowed' => [
                'input' => '\## foo',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-35'
            ],
            'content parse inline' => [
                'input' => '# foo *bar*',
                'output' => Heading::class,
                'render' => '<h1>foo <em>bar</em></h1>',
                'https://github.github.com/gfm/#example-36'
            ],
            'leading and trailing blanks ignored' => [
                'input' => '#                  foo                     ',
                'output' => Heading::class,
                'render' => '<h1>foo</h1>',
                'https://github.github.com/gfm/#example-37'
            ],
            'one spaces indent allowed' => [
                'input' => ' ### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>',
                'https://github.github.com/gfm/#example-38'
            ],
            'two spaces indent allowed' => [
                'input' => '  ### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>',
                'https://github.github.com/gfm/#example-38'
            ],
            'three spaces indent allowed' => [
                'input' => '   ### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>',
                'https://github.github.com/gfm/#example-38'
            ],
            'four spaces too many' => [
                'input' => '    ### foo',
                'output' => null,
                'render' => null,
                'https://github.github.com/gfm/#example-39'
            ],
            'closing sequence of # characters is optional #1' => [
                'input' => '## foo ##',
                'output' => Heading::class,
                'render' => '<h2>foo</h2>',
                'https://github.github.com/gfm/#example-41'
            ],
            'closing sequence of # characters is optional #2' => [
                'input' => '  ###   bar    ###',
                'output' => Heading::class,
                'render' => '<h3>bar</h3>',
                'https://github.github.com/gfm/#example-41'
            ],
            'closing sequence of # characters not need be same length as opening sequence #1' => [
                'input' => '# foo ##################################',
                'output' => Heading::class,
                'render' => '<h1>foo</h1>',
                'https://github.github.com/gfm/#example-42'
            ],
            'closing sequence of # characters not need be same length as opening sequence #2' => [
                'input' => '##### foo ##',
                'output' => Heading::class,
                'render' => '<h5>foo</h5>',
                'https://github.github.com/gfm/#example-42'
            ],
            'spaces allowed after closing sequence' => [
                'input' => '### foo ###     ',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>',
                'https://github.github.com/gfm/#example-43'
            ],
            'closing sequence of # characters followed by anything but spaces it is not a closing sequence' => [
                'input' => '### foo ### b',
                'output' => Heading::class,
                'render' => '<h3>foo ### b</h3>',
                'https://github.github.com/gfm/#example-44'
            ],
            'closing sequence must be preceded by a space' => [
                'input' => '# foo#',
                'output' => Heading::class,
                'render' => '<h1>foo#</h1>',
                'https://github.github.com/gfm/#example-45'
            ],
            'escaped # characters do not count as part of closing sequence #1' => [
                'input' => '### foo \###',
                'output' => Heading::class,
                'render' => '<h3>foo ###</h3>',
                'https://github.github.com/gfm/#example-46'
            ],
            'escaped # characters do not count as part of closing sequence #2' => [
                'input' => '## foo #\##',
                'output' => Heading::class,
                'render' => '<h2>foo ###</h2>',
                'https://github.github.com/gfm/#example-46'
            ],
            'escaped # characters do not count as part of closing sequence #3' => [
                'input' => '# foo \#',
                'output' => Heading::class,
                'render' => '<h1>foo #</h1>',
                'https://github.github.com/gfm/#example-46'
            ],
            'can be empty #1' => [
                'input' => '## ',
                'output' => Heading::class,
                'render' => '<h2></h2>',
                'https://github.github.com/gfm/#example-49'
            ],
            'can be empty #2' => [
                'input' => '#',
                'output' => Heading::class,
                'render' => '<h1></h1>',
                'https://github.github.com/gfm/#example-49'
            ],
            'can be empty #3' => [
                'input' => '### ###',
                'output' => Heading::class,
                'render' => '<h3></h3>',
                'https://github.github.com/gfm/#example-49'
            ],
            'unicode #1' => [
                'input' => '# 1¥',
                'output' => Heading::class,
                'render' => '<h1>1¥</h1>'
            ],
            'unicode #2' => [
                'input' => '### 1¥ ###',
                'output' => Heading::class,
                'render' => '<h3>1¥</h3>'
            ],
            'unicode #3' => [
                'input' => '# 上层控制遮罩（雪）',
                'output' => Heading::class,
                'render' => '<h1>上层控制遮罩（雪）</h1>'
            ],
            'unicode #4' => [
                'input' => '#### 上层控制遮罩（雪） ####',
                'output' => Heading::class,
                'render' => '<h4>上层控制遮罩（雪）</h4>'
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
            'Example 32' => [
                'input' => '# foo
## foo
### foo
#### foo
##### foo
###### foo',
                'output' => '<h1>foo</h1>
<h2>foo</h2>
<h3>foo</h3>
<h4>foo</h4>
<h5>foo</h5>
<h6>foo</h6>',
                'https://github.github.com/gfm/#example-32'
            ],
            'Example 34' => [
                'input' => '#5 bolt

#hashtag',
                'output' => '<p>#5 bolt</p>
<p>#hashtag</p>',
                'https://github.github.com/gfm/#example-34'
            ],
            'Example 38' => [
                'input' => ' ### foo
  ## foo
   # foo',
                'output' => '<h3>foo</h3>
<h2>foo</h2>
<h1>foo</h1>',
                'https://github.github.com/gfm/#example-38'
            ],
            'Example 40' => [
                'input' => 'foo
    # bar',
                'output' => '<p>foo
# bar</p>',
                'https://github.github.com/gfm/#example-40'
            ],
            'Example 41' => [
                'input' => '## foo ##
  ###   bar    ###',
                'output' => '<h2>foo</h2>
<h3>bar</h3>',
                'https://github.github.com/gfm/#example-41'
            ],
            'Example 42' => [
                'input' => '# foo ##################################
##### foo ##',
                'output' => '<h1>foo</h1>
<h5>foo</h5>',
                'https://github.github.com/gfm/#example-42'
            ],
            'Example 46' => [
                'input' => '### foo \###
## foo #\##
# foo \#',
                'output' => '<h3>foo ###</h3>
<h2>foo ###</h2>
<h1>foo #</h1>',
                'https://github.github.com/gfm/#example-46'
            ],
            'Example 47' => [
                'input' => '****
## foo
****',
                'output' => '<hr />
<h2>foo</h2>
<hr />',
                'https://github.github.com/gfm/#example-47'
            ],
            'Example 48' => [
                'input' => 'Foo bar
# baz
Bar foo',
                'output' => '<p>Foo bar</p>
<h1>baz</h1>
<p>Bar foo</p>',
                'https://github.github.com/gfm/#example-48'
            ],
            'Example 49' => [
                'input' => '## 
#
### ###',
                'output' => '<h2></h2>
<h1></h1>
<h3></h3>',
                'https://github.github.com/gfm/#example-49'
            ],
            'Example 50' => [
                'input' => 'Foo *bar*
=========

Foo *bar*
---------',
                'output' => '<h1>Foo <em>bar</em></h1>
<h2>Foo <em>bar</em></h2>',
                'https://github.github.com/gfm/#example-50'
            ],
            'Example 51' => [
                'input' => 'Foo *bar
baz*
====',
                'output' => '<h1>Foo <em>bar
baz</em></h1>',
                'https://github.github.com/gfm/#example-51'
            ],
            'Example 52' => [
                'input' => 'Foo
-------------------------

Foo
=',
                'output' => '<h2>Foo</h2>
<h1>Foo</h1>',
                'https://github.github.com/gfm/#example-52'
            ],
            'Example 53' => [
                'input' => '   Foo
---

  Foo
-----

  Foo
  ===',
                'output' => '<h2>Foo</h2>
<h2>Foo</h2>
<h1>Foo</h1>',
                'https://github.github.com/gfm/#example-53'
            ],
            'Example 54' => [
                'input' => '    Foo
    ---

    Foo
---',
                'output' => '<pre><code>Foo
---

Foo
</code></pre>
<hr />',
                'https://github.github.com/gfm/#example-54'
            ],
            'Example 55' => [
                'input' => 'Foo
   ----      ',
                'output' => '<h2>Foo</h2>',
                'https://github.github.com/gfm/#example-55'
            ],
            'Example 56' => [
                'input' => 'Foo
    ---',
                'output' => '<p>Foo
---</p>',
                'https://github.github.com/gfm/#example-56'
            ],
            'Example 57' => [
                'input' => 'Foo
= =

Foo
--- -',
                'output' => '<p>Foo
= =</p>
<p>Foo</p>
<hr />',
                'https://github.github.com/gfm/#example-57'
            ],
            'Example 58' => [
                'input' => 'Foo  
-----',
                'output' => '<h2>Foo</h2>',
                'https://github.github.com/gfm/#example-58'
            ],
            'Example 59' => [
                'input' => 'Foo\
----',
                'output' => '<h2>Foo\</h2>',
                'https://github.github.com/gfm/#example-59'
            ],
            'Example 60' => [
                'input' => '`Foo
----
`

<a title="a lot
---
of dashes"/>',
                'output' => '<h2>`Foo</h2>
<p>`</p>
<h2>&lt;a title=&quot;a lot</h2>
<p>of dashes&quot;/&gt;</p>',
                'https://github.github.com/gfm/#example-60'
            ],
            'Example 61' => [
                'input' => '> Foo
---',
                'output' => '<blockquote>
<p>Foo</p>
</blockquote>
<hr />',
                'https://github.github.com/gfm/#example-61'
            ],
            'Example 62' => [
                'input' => '> foo
bar
===',
                'output' => '<blockquote>
<p>foo
bar
===</p>
</blockquote>',
                'https://github.github.com/gfm/#example-62'
            ],
            'Example 63' => [
                'input' => '- Foo
---',
                'output' => '<ul>
<li>Foo</li>
</ul>
<hr />',
                'https://github.github.com/gfm/#example-63'
            ],
            'Example 64' => [
                'input' => 'Foo
Bar
---',
                'output' => '<h2>Foo
Bar</h2>',
                'https://github.github.com/gfm/#example-64'
            ],
            'Example 65' => [
                'input' => '---
Foo
---
Bar
---
Baz',
                'output' => '<hr />
<h2>Foo</h2>
<h2>Bar</h2>
<p>Baz</p>',
                'https://github.github.com/gfm/#example-65'
            ],
            'Example 66' => [
                'input' => '
====',
                'output' => '<p>====</p>',
                'https://github.github.com/gfm/#example-66'
            ],
            'Example 67' => [
                'input' => '---
---',
                'output' => '<hr />
<hr />',
                'https://github.github.com/gfm/#example-67'
            ],
            'Example 68' => [
                'input' => '- foo
-----',
                'output' => '<ul>
<li>foo</li>
</ul>
<hr />',
                'https://github.github.com/gfm/#example-68'
            ],
            'Example 69' => [
                'input' => '    foo
---',
                'output' => '<pre><code>foo
</code></pre>
<hr />',
                'https://github.github.com/gfm/#example-69'
            ],
            'Example 70' => [
                'input' => '> foo
-----',
                'output' => '<blockquote>
<p>foo</p>
</blockquote>
<hr />',
                'https://github.github.com/gfm/#example-70'
            ],
            'Example 71' => [
                'input' => '\> foo
------',
                'output' => '<h2>&gt; foo</h2>',
                'https://github.github.com/gfm/#example-71'
            ],
            'Example 72' => [
                'input' => 'Foo

bar
---
baz',
                'output' => '<p>Foo</p>
<h2>bar</h2>
<p>baz</p>',
                'https://github.github.com/gfm/#example-72'
            ],
            'Example 73' => [
                'input' => 'Foo
bar

---

baz',
                'output' => '<p>Foo
bar</p>
<hr />
<p>baz</p>',
                'https://github.github.com/gfm/#example-73'
            ],
            'Example 74' => [
                'input' => 'Foo
bar
* * *
baz',
                'output' => '<p>Foo
bar</p>
<hr />
<p>baz</p>',
                'https://github.github.com/gfm/#example-74'
            ],
            'Example 75' => [
                'input' => 'Foo
bar
\---
baz',
                'output' => '<p>Foo
bar
---
baz</p>',
                'https://github.github.com/gfm/#example-75'
            ],
        ];
    }
}
