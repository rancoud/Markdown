<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\FencedCode;
use Rancoud\Markdown\Markdown;

/**
 * Class FencedCodeTest
 */
class FencedCodeTest extends TestCase
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
        $out = FencedCode::getBlock($input);

        if ($output === null) {
            static::assertNull($out);
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
            'Example 95' => [
                'input' => '```',
                'output' => FencedCode::class,
                'render' => '<pre><code></code></pre>',
                'https://github.github.com/gfm/#example-95'
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
            'Example 88' => [
                'input' => '```
<
 >
```',
                'output' => '<pre><code>&lt;
 &gt;
</code></pre>',
                'https://github.github.com/gfm/#example-88'
            ],
            'Example 89' => [
                'input' => '~~~
<
 >
~~~',
                'output' => '<pre><code>&lt;
 &gt;
</code></pre>',
                'https://github.github.com/gfm/#example-89'
            ],
            'Example 90' => [
                'input' => '``
foo
``',
                'output' => '<p><code>foo</code></p>',
                'https://github.github.com/gfm/#example-90'
            ],
            'Example 91' => [
                'input' => '```
aaa
~~~
```',
                'output' => '<pre><code>aaa
~~~
</code></pre>',
                'https://github.github.com/gfm/#example-91'
            ],
            'Example 92' => [
                'input' => '~~~
aaa
```
~~~',
                'output' => '<pre><code>aaa
```
</code></pre>',
                'https://github.github.com/gfm/#example-92'
            ],
            'Example 93' => [
                'input' => '````
aaa
```
``````',
                'output' => '<pre><code>aaa
```
</code></pre>',
                'https://github.github.com/gfm/#example-93'
            ],
            'Example 94' => [
                'input' => '~~~~
aaa
~~~
~~~~',
                'output' => '<pre><code>aaa
~~~
</code></pre>',
                'https://github.github.com/gfm/#example-94'
            ],
            'Example 96' => [
                'input' => '`````

```
aaa',
                'output' => '<pre><code>
```
aaa
</code></pre>',
                'https://github.github.com/gfm/#example-96'
            ],
            'Example 97' => [
                'input' => '> ```
> aaa

bbb',
                'output' => '<blockquote>
<pre><code>aaa
</code></pre>
</blockquote>
<p>bbb</p>',
                'https://github.github.com/gfm/#example-97'
            ],
            'Example 98' => [
                'input' => '```

  
```',
                'output' => '<pre><code>
  
</code></pre>',
                'https://github.github.com/gfm/#example-98'
            ],
            'Example 99' => [
                'input' => '```
```',
                'output' => '<pre><code></code></pre>',
                'https://github.github.com/gfm/#example-99'
            ],
            'Example 100' => [
                'input' => ' ```
 aaa
aaa
```',
                'output' => '<pre><code>aaa
aaa
</code></pre>',
                'https://github.github.com/gfm/#example-100'
            ],
            'Example 101' => [
                'input' => '  ```
aaa
  aaa
aaa
  ```',
                'output' => '<pre><code>aaa
aaa
aaa
</code></pre>',
                'https://github.github.com/gfm/#example-101'
            ],
            'Example 102' => [
                'input' => '   ```
   aaa
    aaa
  aaa
   ```',
                'output' => '<pre><code>aaa
 aaa
aaa
</code></pre>',
                'https://github.github.com/gfm/#example-102'
            ],
            'Example 103' => [
                'input' => '    ```
    aaa
    ```',
                'output' => '<pre><code>```
aaa
```
</code></pre>',
                'https://github.github.com/gfm/#example-103'
            ],
            'Example 104' => [
                'input' => '```
aaa
  ```',
                'output' => '
aaa
  ```
 
<pre><code>aaa
</code></pre>',
                'https://github.github.com/gfm/#example-104'
            ],
            'Example 105' => [
                'input' => '   ```
aaa
  ```',
                'output' => '<pre><code>aaa
</code></pre>',
                'https://github.github.com/gfm/#example-105'
            ],
            'Example 106' => [
                'input' => '```
aaa
    ```',
                'output' => '<pre><code>aaa
    ```
</code></pre>',
                'https://github.github.com/gfm/#example-106'
            ],
            'Example 107' => [
                'input' => '``` ```
aaa',
                'output' => '<p><code></code>
aaa</p>',
                'https://github.github.com/gfm/#example-107'
            ],
            'Example 108' => [
                'input' => '~~~~~~
aaa
~~~ ~~',
                'output' => '<pre><code>aaa
~~~ ~~
</code></pre>',
                'https://github.github.com/gfm/#example-108'
            ],
            'Example 109' => [
                'input' => 'foo
```
bar
```
baz',
                'output' => '<p>foo</p>
<pre><code>bar
</code></pre>
<p>baz</p>',
                'https://github.github.com/gfm/#example-109'
            ],
            'Example 110' => [
                'input' => 'foo
---
~~~
bar
~~~
# baz',
                'output' => '<h2>foo</h2>
<pre><code>bar
</code></pre>
<h1>baz</h1>',
                'https://github.github.com/gfm/#example-110'
            ],
            'Example 111' => [
                'input' => '```ruby
def foo(x)
  return 3
end
```',
                'output' => '<pre><code class="language-ruby">def foo(x)
  return 3
end
</code></pre>',
                'https://github.github.com/gfm/#example-111'
            ],
            'Example 112' => [
                'input' => '~~~~    ruby startline=3 $%@#$
def foo(x)
  return 3
end
~~~~~~~',
                'output' => '<pre><code class="language-ruby">def foo(x)
  return 3
end
</code></pre>',
                'https://github.github.com/gfm/#example-112'
            ],
            'Example 113' => [
                'input' => '````;
````',
                'output' => '<pre><code class="language-;"></code></pre>',
                'https://github.github.com/gfm/#example-113'
            ],
            'Example 114' => [
                'input' => '``` aa ```
foo',
                'output' => '<p><code>aa</code>
foo</p>',
                'https://github.github.com/gfm/#example-114'
            ],
            'Example 115' => [
                'input' => '```
``` aaa
```',
                'output' => '<pre><code>``` aaa
</code></pre>',
                'https://github.github.com/gfm/#example-115'
            ]
        ];
    }
}
