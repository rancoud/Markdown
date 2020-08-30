<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Markdown;

class ListBlockTest extends TestCase
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
            'Example 224' => [
                'input' => 'A paragraph
with two lines.

    indented code

> A block quote.',
                'output' => '<p>A paragraph
with two lines.</p>
<pre><code>indented code
</code></pre>
<blockquote>
<p>A block quote.</p>
</blockquote>',
                'https://github.github.com/gfm/#example-224'
            ],
            'Example 225' => [
                'input' => '1.  A paragraph
    with two lines.

        indented code

    > A block quote.',
                'output' => '<ol>
<li>
<p>A paragraph
with two lines.</p>
<pre><code>indented code
</code></pre>
<blockquote>
<p>A block quote.</p>
</blockquote>
</li>
</ol>',
                'https://github.github.com/gfm/#example-225'
            ],
            'Example 226' => [
                'input' => '- one

 two',
                'output' => '<ul>
<li>one</li>
</ul>
<p>two</p>',
                'https://github.github.com/gfm/#example-226'
            ],
            'Example 227' => [
                'input' => '- one

  two',
                'output' => '<ul>
<li>
<p>one</p>
<p>two</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-227'
            ],
            'Example 228' => [
                'input' => ' -    one

     two',
                'output' => '<ul>
<li>one</li>
</ul>
<pre><code> two
</code></pre>',
                'https://github.github.com/gfm/#example-228'
            ],
            'Example 229' => [
                'input' => ' -    one

      two',
                'output' => '<ul>
<li>
<p>one</p>
<p>two</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-229'
            ],
            'Example 230' => [
                'input' => '   > > 1.  one
>>
>>     two',
                'output' => '<blockquote>
<blockquote>
<ol>
<li>
<p>one</p>
<p>two</p>
</li>
</ol>
</blockquote>
</blockquote>',
                'https://github.github.com/gfm/#example-230'
            ],
            'Example 231' => [
                'input' => '>>- one
>>
  >  > two',
                'output' => '<blockquote>
<blockquote>
<ul>
<li>one</li>
</ul>
<p>two</p>
</blockquote>
</blockquote>',
                'https://github.github.com/gfm/#example-231'
            ],
            'Example 232' => [
                'input' => '-one

2.two',
                'output' => '<p>-one</p>
<p>2.two</p>',
                'https://github.github.com/gfm/#example-232'
            ],
            'Example 233' => [
                'input' => '- foo


  bar',
                'output' => '<ul>
<li>
<p>foo</p>
<p>bar</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-233'
            ],
            'Example 234' => [
                'input' => '1.  foo

    ```
    bar
    ```

    baz

    > bam',
                'output' => '<ol>
<li>
<p>foo</p>
<pre><code>bar
</code></pre>
<p>baz</p>
<blockquote>
<p>bam</p>
</blockquote>
</li>
</ol>',
                'https://github.github.com/gfm/#example-234'
            ],
            'Example 235' => [
                'input' => '- Foo

      bar


      baz',
                'output' => '<ul>
<li>
<p>Foo</p>
<pre><code>bar


baz
</code></pre>
</li>
</ul>',
                'https://github.github.com/gfm/#example-235'
            ],
            'Example 236' => [
                'input' => '123456789. ok',
                'output' => '<ol start="123456789">
<li>ok</li>
</ol>',
                'https://github.github.com/gfm/#example-236'
            ],
            'Example 237' => [
                'input' => '1234567890. not ok',
                'output' => '<p>1234567890. not ok</p>',
                'https://github.github.com/gfm/#example-237'
            ],
            'Example 238' => [
                'input' => '0. ok',
                'output' => '<ol start="0">
<li>ok</li>
</ol>',
                'https://github.github.com/gfm/#example-238'
            ],
            'Example 239' => [
                'input' => '003. ok',
                'output' => '<ol start="3">
<li>ok</li>
</ol>',
                'https://github.github.com/gfm/#example-239'
            ],
            'Example 240' => [
                'input' => '-1. not ok',
                'output' => '<p>-1. not ok</p>',
                'https://github.github.com/gfm/#example-240'
            ],
            'Example 241' => [
                'input' => '- foo

      bar',
                'output' => '<ul>
<li>
<p>foo</p>
<pre><code>bar
</code></pre>
</li>
</ul>',
                'https://github.github.com/gfm/#example-241'
            ],
            'Example 242' => [
                'input' => '  10.  foo

           bar',
                'output' => '<ol start="10">
<li>
<p>foo</p>
<pre><code>bar
</code></pre>
</li>
</ol>',
                'https://github.github.com/gfm/#example-242'
            ],
            'Example 243' => [
                'input' => '    indented code

paragraph

    more code',
                'output' => '<pre><code>indented code
</code></pre>
<p>paragraph</p>
<pre><code>more code
</code></pre>',
                'https://github.github.com/gfm/#example-243'
            ],
            'Example 244' => [
                'input' => '1.     indented code

   paragraph

       more code',
                'output' => '<ol>
<li>
<pre><code>indented code
</code></pre>
<p>paragraph</p>
<pre><code>more code
</code></pre>
</li>
</ol>',
                'https://github.github.com/gfm/#example-244'
            ],
            'Example 245' => [
                'input' => '1.      indented code

   paragraph

       more code',
                'output' => '<ol>
<li>
<pre><code> indented code
</code></pre>
<p>paragraph</p>
<pre><code>more code
</code></pre>
</li>
</ol>',
                'https://github.github.com/gfm/#example-245'
            ],
            'Example 246' => [
                'input' => '   foo

bar',
                'output' => '<p>foo</p>
<p>bar</p>',
                'https://github.github.com/gfm/#example-246'
            ],
            'Example 247' => [
                'input' => '-    foo

  bar',
                'output' => '<ul>
<li>foo</li>
</ul>
<p>bar</p>',
                'https://github.github.com/gfm/#example-247'
            ],
            'Example 248' => [
                'input' => '-  foo

   bar',
                'output' => '<ul>
<li>
<p>foo</p>
<p>bar</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-248'
            ],
            'Example 249' => [
                'input' => '-
  foo
-
  ```
  bar
  ```
-
      baz',
                'output' => '<ul>
<li>foo</li>
<li>
<pre><code>bar
</code></pre>
</li>
<li>
<pre><code>baz
</code></pre>
</li>
</ul>',
                'https://github.github.com/gfm/#example-249'
            ],
            'Example 250' => [
                'input' => '-   
  foo',
                'output' => '<ul>
<li>foo</li>
</ul>',
                'https://github.github.com/gfm/#example-228'
            ],
            'Example 251' => [
                'input' => '-

  foo',
                'output' => '<ul>
<li></li>
</ul>
<p>foo</p>',
                'https://github.github.com/gfm/#example-228'
            ],
            'Example 252' => [
                'input' => '- foo
-
- bar',
                'output' => '<ul>
<li>foo</li>
<li></li>
<li>bar</li>
</ul>',
                'https://github.github.com/gfm/#example-252'
            ],
            'Example 253' => [
                'input' => '- foo
-   
- bar',
                'output' => '<ul>
<li>foo</li>
<li></li>
<li>bar</li>
</ul>',
                'https://github.github.com/gfm/#example-253'
            ],
            'Example 254' => [
                'input' => '1. foo
2.
3. bar',
                'output' => '<ol>
<li>foo</li>
<li></li>
<li>bar</li>
</ol>',
                'https://github.github.com/gfm/#example-254'
            ],
            'Example 255' => [
                'input' => '*',
                'output' => '<ul>
<li></li>
</ul>',
                'https://github.github.com/gfm/#example-255'
            ],
            'Example 256' => [
                'input' => 'foo
*

foo
1.',
                'output' => '<p>foo
*</p>
<p>foo
1.</p>',
                'https://github.github.com/gfm/#example-256'
            ],
            'Example 257' => [
                'input' => ' 1.  A paragraph
     with two lines.

         indented code

     > A block quote.',
                'output' => '<ol>
<li>
<p>A paragraph
with two lines.</p>
<pre><code>indented code
</code></pre>
<blockquote>
<p>A block quote.</p>
</blockquote>
</li>
</ol>',
                'https://github.github.com/gfm/#example-257'
            ],
            'Example 258' => [
                'input' => '  1.  A paragraph
      with two lines.

          indented code

      > A block quote.',
                'output' => '<ol>
<li>
<p>A paragraph
with two lines.</p>
<pre><code>indented code
</code></pre>
<blockquote>
<p>A block quote.</p>
</blockquote>
</li>
</ol>',
                'https://github.github.com/gfm/#example-258'
            ],
            'Example 259' => [
                'input' => '   1.  A paragraph
       with two lines.

           indented code

       > A block quote.',
                'output' => '<ol>
<li>
<p>A paragraph
with two lines.</p>
<pre><code>indented code
</code></pre>
<blockquote>
<p>A block quote.</p>
</blockquote>
</li>
</ol>',
                'https://github.github.com/gfm/#example-259'
            ],
            'Example 260' => [
                'input' => '    1.  A paragraph
        with two lines.

            indented code

        > A block quote.',
                'output' => '<pre><code>1.  A paragraph
    with two lines.

        indented code

    &gt; A block quote.
</code></pre>',
                'https://github.github.com/gfm/#example-260'
            ],
            'Example 261' => [
                'input' => '  1.  A paragraph
with two lines.

          indented code

      > A block quote.',
                'output' => '<ol>
<li>
<p>A paragraph
with two lines.</p>
<pre><code>indented code
</code></pre>
<blockquote>
<p>A block quote.</p>
</blockquote>
</li>
</ol>',
                'https://github.github.com/gfm/#example-261'
            ],
            'Example 262' => [
                'input' => '  1.  A paragraph
    with two lines.',
                'output' => '<ol>
<li>A paragraph
with two lines.</li>
</ol>',
                'https://github.github.com/gfm/#example-262'
            ],
            'Example 263' => [
                'input' => '> 1. > Blockquote
continued here.',
                'output' => '<blockquote>
<ol>
<li>
<blockquote>
<p>Blockquote
continued here.</p>
</blockquote>
</li>
</ol>
</blockquote>',
                'https://github.github.com/gfm/#example-263'
            ],
            'Example 264' => [
                'input' => '> 1. > Blockquote
> continued here.',
                'output' => '<blockquote>
<ol>
<li>
<blockquote>
<p>Blockquote
continued here.</p>
</blockquote>
</li>
</ol>
</blockquote>',
                'https://github.github.com/gfm/#example-264'
            ],
            'Example 265' => [
                'input' => '- foo
  - bar
    - baz
      - boo',
                'output' => '<ul>
<li>foo
<ul>
<li>bar
<ul>
<li>baz
<ul>
<li>boo</li>
</ul>
</li>
</ul>
</li>
</ul>
</li>
</ul>',
                'https://github.github.com/gfm/#example-265'
            ],
            'Example 266' => [
                'input' => '- foo
 - bar
  - baz
   - boo',
                'output' => '<ul>
<li>foo</li>
<li>bar</li>
<li>baz</li>
<li>boo</li>
</ul>',
                'https://github.github.com/gfm/#example-266'
            ],
            'Example 267' => [
                'input' => '10) foo
    - bar',
                'output' => '<ol start="10">
<li>foo
<ul>
<li>bar</li>
</ul>
</li>
</ol>',
                'https://github.github.com/gfm/#example-267'
            ],
            'Example 268' => [
                'input' => '10) foo
   - bar',
                'output' => '<ol start="10">
<li>foo</li>
</ol>
<ul>
<li>bar</li>
</ul>',
                'https://github.github.com/gfm/#example-268'
            ],
            'Example 269' => [
                'input' => '- - foo',
                'output' => '<ul>
<li>
<ul>
<li>foo</li>
</ul>
</li>
</ul>',
                'https://github.github.com/gfm/#example-269'
            ],
            'Example 270' => [
                'input' => '1. - 2. foo',
                'output' => '<ol>
<li>
<ul>
<li>
<ol start="2">
<li>foo</li>
</ol>
</li>
</ul>
</li>
</ol>',
                'https://github.github.com/gfm/#example-270'
            ],
            'Example 271' => [
                'input' => '- # Foo
- Bar
  ---
  baz',
                'output' => '<ul>
<li>
<h1>Foo</h1>
</li>
<li>
<h2>Bar</h2>
baz</li>
</ul>',
                'https://github.github.com/gfm/#example-271'
            ],
            'Example 272' => [
                'input' => '- [ ] foo
- [x] bar',
                'output' => '<ul>
<li><input disabled="" type="checkbox"> foo</li>
<li><input checked="" disabled="" type="checkbox"> bar</li>
</ul>',
                'https://github.github.com/gfm/#example-272'
            ],
            'Example 273' => [
                'input' => '- [x] foo
  - [ ] bar
  - [x] baz
- [ ] bim',
                'output' => '<ul>
<li><input checked="" disabled="" type="checkbox"> foo
<ul>
<li><input disabled="" type="checkbox"> bar</li>
<li><input checked="" disabled="" type="checkbox"> baz</li>
</ul>
</li>
<li><input disabled="" type="checkbox"> bim</li>
</ul>',
                'https://github.github.com/gfm/#example-273'
            ],
            'Example 274' => [
                'input' => '- foo
- bar
+ baz',
                'output' => '<ul>
<li>foo</li>
<li>bar</li>
</ul>
<ul>
<li>baz</li>
</ul>',
                'https://github.github.com/gfm/#example-274'
            ],
            'Example 275' => [
                'input' => '1. foo
2. bar
3) baz',
                'output' => '<ol>
<li>foo</li>
<li>bar</li>
</ol>
<ol start="3">
<li>baz</li>
</ol>',
                'https://github.github.com/gfm/#example-275'
            ],
            'Example 276' => [
                'input' => 'Foo
- bar
- baz',
                'output' => '<p>Foo</p>
<ul>
<li>bar</li>
<li>baz</li>
</ul>',
                'https://github.github.com/gfm/#example-276'
            ],
            'Example 277' => [
                'input' => 'The number of windows in my house is
14.  The number of doors is 6.',
                'output' => '<p>The number of windows in my house is
14.  The number of doors is 6.</p>',
                'https://github.github.com/gfm/#example-277'
            ],
            'Example 278' => [
                'input' => 'The number of windows in my house is
1.  The number of doors is 6.',
                'output' => '<p>The number of windows in my house is</p>
<ol>
<li>The number of doors is 6.</li>
</ol>',
                'https://github.github.com/gfm/#example-278'
            ],
            'Example 279' => [
                'input' => '- foo

- bar


- baz',
                'output' => '<ul>
<li>
<p>foo</p>
</li>
<li>
<p>bar</p>
</li>
<li>
<p>baz</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-279'
            ],
            'Example 280' => [
                'input' => '- foo
  - bar
    - baz


      bim',
                'output' => '<ul>
<li>foo
<ul>
<li>bar
<ul>
<li>
<p>baz</p>
<p>bim</p>
</li>
</ul>
</li>
</ul>
</li>
</ul>',
                'https://github.github.com/gfm/#example-280'
            ],
            'Example 281' => [
                'input' => '- foo
- bar

<!-- -->

- baz
- bim',
                'output' => '<ul>
<li>foo</li>
<li>bar</li>
</ul>
<!-- -->
<ul>
<li>baz</li>
<li>bim</li>
</ul>',
                'https://github.github.com/gfm/#example-281'
            ],
            'Example 282' => [
                'input' => '-   foo

    notcode

-   foo

<!-- -->

    code',
                'output' => '<ul>
<li>
<p>foo</p>
<p>notcode</p>
</li>
<li>
<p>foo</p>
</li>
</ul>
<!-- -->
<pre><code>code
</code></pre>',
                'https://github.github.com/gfm/#example-282'
            ],
            'Example 283' => [
                'input' => '- a
 - b
  - c
   - d
  - e
 - f
- g',
                'output' => '<ul>
<li>a</li>
<li>b</li>
<li>c</li>
<li>d</li>
<li>e</li>
<li>f</li>
<li>g</li>
</ul>',
                'https://github.github.com/gfm/#example-283'
            ],
            'Example 284' => [
                'input' => '1. a

  2. b

   3. c',
                'output' => '<ol>
<li>
<p>a</p>
</li>
<li>
<p>b</p>
</li>
<li>
<p>c</p>
</li>
</ol>',
                'https://github.github.com/gfm/#example-284'
            ],
            'Example 285' => [
                'input' => '- a
 - b
  - c
   - d
    - e',
                'output' => '<ul>
<li>a</li>
<li>b</li>
<li>c</li>
<li>d
- e</li>
</ul>',
                'https://github.github.com/gfm/#example-285'
            ],
            'Example 286' => [
                'input' => '1. a

  2. b

    3. c',
                'output' => '<ol>
<li>
<p>a</p>
</li>
<li>
<p>b</p>
</li>
</ol>
<pre><code>3. c
</code></pre>',
                'https://github.github.com/gfm/#example-286'
            ],
            'Example 287' => [
                'input' => '- a
- b

- c',
                'output' => '<ul>
<li>
<p>a</p>
</li>
<li>
<p>b</p>
</li>
<li>
<p>c</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-287'
            ],
            'Example 288' => [
                'input' => '* a
*

* c',
                'output' => '<ul>
<li>
<p>a</p>
</li>
<li></li>
<li>
<p>c</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-288'
            ],
            'Example 289' => [
                'input' => '- a
- b

  c
- d',
                'output' => '<ul>
<li>
<p>a</p>
</li>
<li>
<p>b</p>
<p>c</p>
</li>
<li>
<p>d</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-289'
            ],
            'Example 290' => [
                'input' => '- a
- b

  [ref]: /url
- d',
                'output' => '<ul>
<li>
<p>a</p>
</li>
<li>
<p>b</p>
</li>
<li>
<p>d</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-290'
            ],
            'Example 291' => [
                'input' => '- a
- ```
  b


  ```
- c',
                'output' => '<ul>
<li>a</li>
<li>
<pre><code>b


</code></pre>
</li>
<li>c</li>
</ul>',
                'https://github.github.com/gfm/#example-291'
            ],
            'Example 292' => [
                'input' => '- a
  - b

    c
- d',
                'output' => '<ul>
<li>a
<ul>
<li>
<p>b</p>
<p>c</p>
</li>
</ul>
</li>
<li>d</li>
</ul>',
                'https://github.github.com/gfm/#example-292'
            ],
            'Example 293' => [
                'input' => '* a
  > b
  >
* c',
                'output' => '<ul>
<li>a
<blockquote>
<p>b</p>
</blockquote>
</li>
<li>c</li>
</ul>',
                'https://github.github.com/gfm/#example-293'
            ],
            'Example 294' => [
                'input' => '- a
  > b
  ```
  c
  ```
- d',
                'output' => '<ul>
<li>a
<blockquote>
<p>b</p>
</blockquote>
<pre><code>c
</code></pre>
</li>
<li>d</li>
</ul>',
                'https://github.github.com/gfm/#example-294'
            ],
            'Example 295' => [
                'input' => '- a',
                'output' => '<ul>
<li>a</li>
</ul>',
                'https://github.github.com/gfm/#example-295'
            ],
            'Example 296' => [
                'input' => '- a
  - b',
                'output' => '<ul>
<li>a
<ul>
<li>b</li>
</ul>
</li>
</ul>',
                'https://github.github.com/gfm/#example-296'
            ],
            'Example 297' => [
                'input' => '1. ```
   foo
   ```

   bar',
                'output' => '<ol>
<li>
<pre><code>foo
</code></pre>
<p>bar</p>
</li>
</ol>',
                'https://github.github.com/gfm/#example-297'
            ],
            'Example 298' => [
                'input' => '* foo
  * bar

  baz',
                'output' => '<ul>
<li>
<p>foo</p>
<ul>
<li>bar</li>
</ul>
<p>baz</p>
</li>
</ul>',
                'https://github.github.com/gfm/#example-298'
            ],
            'Example 299' => [
                'input' => '- a
  - b
  - c

- d
  - e
  - f',
                'output' => '<ul>
<li>
<p>a</p>
<ul>
<li>b</li>
<li>c</li>
</ul>
</li>
<li>
<p>d</p>
<ul>
<li>e</li>
<li>f</li>
</ul>
</li>
</ul>',
                'https://github.github.com/gfm/#example-299'
            ]
        ];
    }
}
