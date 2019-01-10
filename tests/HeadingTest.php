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
    public function testIsMe(string $input, ?string $output, ?string $render)
    {
        $m = new Markdown();
        $out = Heading::isMe($input);

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
            'simple heading #1' => [
                'input' => '# foo',
                'output' => Heading::class,
                'render' => '<h1>foo</h1>'
            ],
            'simple heading #2' => [
                'input' => '## foo',
                'output' => Heading::class,
                'render' => '<h2>foo</h2>'
            ],
            'simple heading #3' => [
                'input' => '### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>'
            ],
            'simple heading #4' => [
                'input' => '#### foo',
                'output' => Heading::class,
                'render' => '<h4>foo</h4>'
            ],
            'simple heading #5' => [
                'input' => '##### foo',
                'output' => Heading::class,
                'render' => '<h5>foo</h5>'
            ],
            'simple heading #6' => [
                'input' => '###### foo',
                'output' => Heading::class,
                'render' => '<h6>foo</h6>'
            ],
            'excess # not a heading' => [
                'input' => '####### foo',
                'output' => null,
                'render' => null
            ],
            'no space after # #1' => [
                'input' => '#5 bolt',
                'output' => null,
                'render' => null
            ],
            'no space after # #2' => [
                'input' => '#hashtag',
                'output' => null,
                'render' => null
            ],
            'no escape allowed' => [
                'input' => '\## foo',
                'output' => null,
                'render' => null
            ],
            'content parse inline' => [
                'input' => '# foo *bar*',
                'output' => Heading::class,
                'render' => '<h1>foo <em>bar</em></h1>'
            ],
            'leading and trailing blanks ignored' => [
                'input' => '#                  foo                     ',
                'output' => Heading::class,
                'render' => '<h1>foo</h1>'
            ],
            'one spaces indent allowed' => [
                'input' => ' ### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>'
            ],
            'two spaces indent allowed' => [
                'input' => '  ### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>'
            ],
            'three spaces indent allowed' => [
                'input' => '   ### foo',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>'
            ],
            'four spaces too many' => [
                'input' => '    ### foo',
                'output' => null,
                'render' => null
            ],
            'closing sequence of # characters is optional #1' => [
                'input' => '## foo ##',
                'output' => Heading::class,
                'render' => '<h2>foo</h2>'
            ],
            'closing sequence of # characters is optional #2' => [
                'input' => '  ###   bar    ###',
                'output' => Heading::class,
                'render' => '<h3>bar</h3>'
            ],
            'closing sequence of # characters not need be same length as opening sequence #1' => [
                'input' => '# foo ##################################',
                'output' => Heading::class,
                'render' => '<h1>foo</h1>'
            ],
            'closing sequence of # characters not need be same length as opening sequence #2' => [
                'input' => '##### foo ##',
                'output' => Heading::class,
                'render' => '<h5>foo</h5>'
            ],
            'spaces allowed after closing sequence' => [
                'input' => '### foo ###     ',
                'output' => Heading::class,
                'render' => '<h3>foo</h3>'
            ],
            'closing sequence of # characters followed by anything but spaces it is not a closing sequence' => [
                'input' => '### foo ### b',
                'output' => Heading::class,
                'render' => '<h3>foo ### b</h3>'
            ],
            'closing sequence must be preceded by a space' => [
                'input' => '# foo#',
                'output' => Heading::class,
                'render' => '<h1>foo#</h1>'
            ],
            'escaped # characters do not count as part of closing sequence #1' => [
                'input' => '### foo \###',
                'output' => Heading::class,
                'render' => '<h3>foo ###</h3>'
            ],
            'escaped # characters do not count as part of closing sequence #2' => [
                'input' => '## foo #\##',
                'output' => Heading::class,
                'render' => '<h2>foo ###</h2>'
            ],
            'escaped # characters do not count as part of closing sequence #3' => [
                'input' => '# foo \#',
                'output' => Heading::class,
                'render' => '<h1>foo #</h1>'
            ],
            'can be empty #1' => [
                'input' => '## ',
                'output' => Heading::class,
                'render' => '<h2></h2>'
            ],
            'can be empty #2' => [
                'input' => '#',
                'output' => Heading::class,
                'render' => '<h1></h1>'
            ],
            'can be empty #3' => [
                'input' => '### ###',
                'output' => Heading::class,
                'render' => '<h3></h3>'
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
}
