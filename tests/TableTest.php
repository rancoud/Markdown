<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Block\Table;
use Rancoud\Markdown\Markdown;

/**
 * Class TableTest
 */
class TableTest extends TestCase
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
        $out = Table::isMe($input);

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
            'table' => [
                'input' => '|',
                'output' => Table::class,
                'render' => '<table></table>'
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
            'Example 191' => [
                'input' => '| foo | bar |
| --- | --- |
| baz | bim |',
                'output' => '<table>
<thead>
<tr>
<th>foo</th>
<th>bar</th>
</tr>
</thead>
<tbody>
<tr>
<td>baz</td>
<td>bim</td>
</tr></tbody></table>',
                'https://github.github.com/gfm/#example-191'
            ],
            'Example 192' => [
                'input' => '| abc | defghi |
:-: | -----------:
bar | baz',
                'output' => '<table>
<thead>
<tr>
<th align="center">abc</th>
<th align="right">defghi</th>
</tr>
</thead>
<tbody>
<tr>
<td align="center">bar</td>
<td align="right">baz</td>
</tr></tbody></table>',
                'https://github.github.com/gfm/#example-192'
            ],
            'Example 193' => [
                'input' => '| f\|oo  |
| ------ |
| b `\|` az |
| b **\|** im |',
                'output' => '<table>
<thead>
<tr>
<th>f|oo</th>
</tr>
</thead>
<tbody>
<tr>
<td>b <code>|</code> az</td>
</tr>
<tr>
<td>b <strong>|</strong> im</td>
</tr></tbody></table>',
                'https://github.github.com/gfm/#example-193'
            ],
            'Example 194' => [
                'input' => '| abc | def |
| --- | --- |
| bar | baz |
> bar',
                'output' => '<table>
<thead>
<tr>
<th>abc</th>
<th>def</th>
</tr>
</thead>
<tbody>
<tr>
<td>bar</td>
<td>baz</td>
</tr></tbody></table>
<blockquote>
<p>bar</p>
</blockquote>',
                'https://github.github.com/gfm/#example-194'
            ],
            'Example 195' => [
                'input' => '| abc | def |
| --- | --- |
| bar | baz |
bar

bar',
                'output' => '<table>
<thead>
<tr>
<th>abc</th>
<th>def</th>
</tr>
</thead>
<tbody>
<tr>
<td>bar</td>
<td>baz</td>
</tr>
<tr>
<td>bar</td>
<td></td>
</tr></tbody></table>
<p>bar</p>',
                'https://github.github.com/gfm/#example-195'
            ],
            'Example 196' => [
                'input' => '| abc | def |
| --- |
| bar |',
                'output' => '<p>| abc | def |
| --- |
| bar |</p>',
                'https://github.github.com/gfm/#example-196'
            ],
            'Example 197' => [
                'input' => '| abc | def |
| --- | --- |
| bar |
| bar | baz | boo |',
                'output' => '<table>
<thead>
<tr>
<th>abc</th>
<th>def</th>
</tr>
</thead>
<tbody>
<tr>
<td>bar</td>
<td></td>
</tr>
<tr>
<td>bar</td>
<td>baz</td>
</tr></tbody></table>',
                'https://github.github.com/gfm/#example-197'
            ],
            'Example 198' => [
                'input' => '| abc | def |
| --- | --- |',
                'output' => '<table>
<thead>
<tr>
<th>abc</th>
<th>def</th>
</tr>
</thead></table>',
                'https://github.github.com/gfm/#example-198'
            ]
        ];
    }
}
