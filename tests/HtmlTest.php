<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\Html;
use Rancoud\Markdown\Markdown;

class HtmlTest extends TestCase
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
        $out = Html::getBlock($input);

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
            'Html #1' => [
                'input' => '<ins>',
                'output' => Html::class,
                'render' => '<ins>'
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

    public function dataMarkdown()
    {
        return [
            'Example 116' => [
                'input' => '<table><tr><td>
<pre>
**Hello**,

_world_.
</pre>
</td></tr></table>',
                'output' => '<table><tr><td>
<pre>
**Hello**,
<p><em>world</em>.
</pre></p>
</td></tr></table>',
                'https://github.github.com/gfm/#example-116'
            ],
            'Example 117' => [
                'input' => '<table>
  <tr>
    <td>
           hi
    </td>
  </tr>
</table>

okay.',
                'output' => '<table>
  <tr>
    <td>
           hi
    </td>
  </tr>
</table>
<p>okay.</p>',
                'https://github.github.com/gfm/#example-117'
            ],
            'Example 118' => [
                'input' => ' <div>
  *hello*
         <foo><a>',
                'output' => ' <div>
  *hello*
         <foo><a>',
                'https://github.github.com/gfm/#example-118'
            ],
            'Example 119' => [
                'input' => '</div>
*foo*',
                'output' => '</div>
*foo*',
                'https://github.github.com/gfm/#example-119'
            ],
            'Example 120' => [
                'input' => '<DIV CLASS="foo">

*Markdown*

</DIV>',
                'output' => '<DIV CLASS="foo">
<p><em>Markdown</em></p>
</DIV>',
                'https://github.github.com/gfm/#example-120'
            ],
            'Example 121' => [
                'input' => '<div id="foo"
  class="bar">
</div>',
                'output' => '<div id="foo"
  class="bar">
</div>',
                'https://github.github.com/gfm/#example-121'
            ],
            'Example 122' => [
                'input' => '<div id="foo" class="bar
  baz">
</div>',
                'output' => '<div id="foo" class="bar
  baz">
</div>',
                'https://github.github.com/gfm/#example-122'
            ],
            'Example 123' => [
                'input' => '<div>
*foo*

*bar*',
                'output' => '<div>
*foo*
<p><em>bar</em></p>',
                'https://github.github.com/gfm/#example-123'
            ],
            'Example 124' => [
                'input' => '<div id="foo"
*hi*',
                'output' => '<div id="foo"
*hi*',
                'https://github.github.com/gfm/#example-124'
            ],
            'Example 125' => [
                'input' => '<div class
foo',
                'output' => '<div class
foo',
                'https://github.github.com/gfm/#example-125'
            ],
            'Example 126' => [
                'input' => '<div *???-&&&-<---
*foo*',
                'output' => '<div *???-&&&-<---
*foo*',
                'https://github.github.com/gfm/#example-126'
            ],
            'Example 127' => [
                'input' => '<div><a href="bar">*foo*</a></div>',
                'output' => '<div><a href="bar">*foo*</a></div>',
                'https://github.github.com/gfm/#example-127'
            ],
            'Example 128' => [
                'input' => '<table><tr><td>
foo
</td></tr></table>',
                'output' => '<table><tr><td>
foo
</td></tr></table>',
                'https://github.github.com/gfm/#example-128'
            ],
            'Example 129' => [
                'input' => '<div></div>
``` c
int x = 33;
```',
                'output' => '<div></div>
``` c
int x = 33;
```',
                'https://github.github.com/gfm/#example-129'
            ],
            'Example 130' => [
                'input' => '<a href="foo">
*bar*
</a>',
                'output' => '<a href="foo">
*bar*
</a>',
                'https://github.github.com/gfm/#example-130'
            ],
            'Example 131' => [
                'input' => '<Warning>
*bar*
</Warning>',
                'output' => '<Warning>
*bar*
</Warning>',
                'https://github.github.com/gfm/#example-131'
            ],
            'Example 132' => [
                'input' => '<i class="foo">
*bar*
</i>',
                'output' => '<i class="foo">
*bar*
</i>',
                'https://github.github.com/gfm/#example-132'
            ],
            'Example 133' => [
                'input' => '</ins>
*bar*',
                'output' => '</ins>
*bar*',
                'https://github.github.com/gfm/#example-133'
            ],
            'Example 134' => [
                'input' => '<del>
*foo*
</del>',
                'output' => '<del>
*foo*
</del>',
                'https://github.github.com/gfm/#example-134'
            ],
            'Example 135' => [
                'input' => '<del>

*foo*

</del>',
                'output' => '<del>
<p><em>foo</em></p>
</del>',
                'https://github.github.com/gfm/#example-135'
            ],
            'Example 136' => [
                'input' => '<del>*foo*</del>',
                'output' => '<p><del><em>foo</em></del></p>',
                'https://github.github.com/gfm/#example-136'
            ],
            'Example 137' => [
                'input' => '<pre language="haskell"><code>
import Text.HTML.TagSoup

main :: IO ()
main = print $ parseTags tags
</code></pre>
okay',
                'output' => '<pre language="haskell"><code>
import Text.HTML.TagSoup

main :: IO ()
main = print $ parseTags tags
</code></pre>
<p>okay</p>',
                'https://github.github.com/gfm/#example-137'
            ],
            'Example 138' => [
                'input' => '<script type="text/javascript">
// JavaScript example

document.getElementById("demo").innerHTML = "Hello JavaScript!";
</script>
okay',
                'output' => '<script type="text/javascript">
// JavaScript example

document.getElementById("demo").innerHTML = "Hello JavaScript!";
</script>
<p>okay</p>',
                'https://github.github.com/gfm/#example-138'
            ],
            'Example 139' => [
                'input' => '<style
  type="text/css">
h1 {color:red;}

p {color:blue;}
</style>
okay',
                'output' => '<style
  type="text/css">
h1 {color:red;}

p {color:blue;}
</style>
<p>okay</p>',
                'https://github.github.com/gfm/#example-139'
            ],
            'Example 140' => [
                'input' => '<style
  type="text/css">

foo',
                'output' => '<style
  type="text/css">

foo',
                'https://github.github.com/gfm/#example-140'
            ],
            'Example 141' => [
                'input' => '> <div>
> foo

bar',
                'output' => '<blockquote>
<div>
foo
</blockquote>
<p>bar</p>',
                'https://github.github.com/gfm/#example-141'
            ],
            'Example 142' => [
                'input' => '- <div>
- foo',
                'output' => '<ul>
<li>
<div>
</li>
<li>foo</li>
</ul>',
                'https://github.github.com/gfm/#example-142'
            ],
            'Example 143' => [
                'input' => '<style>p{color:red;}</style>
*foo*',
                'output' => '<style>p{color:red;}</style>
<p><em>foo</em></p>',
                'https://github.github.com/gfm/#example-143'
            ],
            'Example 144' => [
                'input' => '<!-- foo -->*bar*
*baz*',
                'output' => '<!-- foo -->*bar*
<p><em>baz</em></p>',
                'https://github.github.com/gfm/#example-144'
            ],
            'Example 145' => [
                'input' => '<script>
foo
</script>1. *bar*',
                'output' => '<script>
foo
</script>1. *bar*',
                'https://github.github.com/gfm/#example-145'
            ],
            'Example 146' => [
                'input' => '<!-- Foo

bar
   baz -->
okay',
                'output' => '<!-- Foo

bar
   baz -->
<p>okay</p>',
                'https://github.github.com/gfm/#example-146'
            ],
            'Example 147' => [
                'input' => '<?php

  echo \'>\';

?>
okay',
                'output' => '<?php

  echo \'>\';

?>
<p>okay</p>',
                'https://github.github.com/gfm/#example-147'
            ],
            'Example 148' => [
                'input' => '<!DOCTYPE html>',
                'output' => '<!DOCTYPE html>',
                'https://github.github.com/gfm/#example-148'
            ],
            'Example 149' => [
                'input' => '<![CDATA[
function matchwo(a,b)
{
  if (a < b && a < 0) then {
    return 1;

  } else {

    return 0;
  }
}
]]>
okay',
                'output' => '<![CDATA[
function matchwo(a,b)
{
  if (a < b && a < 0) then {
    return 1;

  } else {

    return 0;
  }
}
]]>
<p>okay</p>',
                'https://github.github.com/gfm/#example-149'
            ],
            'Example 150' => [
                'input' => '  <!-- foo -->

    <!-- foo -->',
                'output' => '  <!-- foo -->
<pre><code>&lt;!-- foo --&gt;
</code></pre>',
                'https://github.github.com/gfm/#example-150'
            ],
            'Example 151' => [
                'input' => '  <div>

    <div>',
                'output' => '  <div>
<pre><code>&lt;div&gt;
</code></pre>',
                'https://github.github.com/gfm/#example-151'
            ],
            'Example 152' => [
                'input' => 'Foo
<div>
bar
</div>',
                'output' => '<p>Foo</p>
<div>
bar
</div>',
                'https://github.github.com/gfm/#example-152'
            ],
            'Example 153' => [
                'input' => '<div>
bar
</div>
*foo*',
                'output' => '<div>
bar
</div>
*foo*',
                'https://github.github.com/gfm/#example-153'
            ],
            'Example 154' => [
                'input' => 'Foo
<a href="bar">
baz',
                'output' => '<p>Foo
<a href="bar">
baz</p>',
                'https://github.github.com/gfm/#example-154'
            ],
            'Example 155' => [
                'input' => '<div>

*Emphasized* text.

</div>',
                'output' => '<div>
<p><em>Emphasized</em> text.</p>
</div>',
                'https://github.github.com/gfm/#example-155'
            ],
            'Example 156' => [
                'input' => '<div>
*Emphasized* text.
</div>',
                'output' => '<div>
*Emphasized* text.
</div>',
                'https://github.github.com/gfm/#example-156'
            ],
            'Example 157' => [
                'input' => '<table>

<tr>

<td>
Hi
</td>

</tr>

</table>',
                'output' => '<table>
<tr>
<td>
Hi
</td>
</tr>
</table>',
                'https://github.github.com/gfm/#example-157'
            ],
            'Example 158' => [
                'input' => '<table>

  <tr>

    <td>
      Hi
    </td>

  </tr>

</table>',
                'output' => '<table>
  <tr>
<pre><code>&lt;td&gt;
  Hi
&lt;/td&gt;
</code></pre>
  </tr>
</table>',
                'https://github.github.com/gfm/#example-158'
            ]
        ];
    }
}
