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
    public function testIsMe(string $input, ?string $output, ?string $render)
    {
        $m = new Markdown();
        $out = ThematicBreak::isMe($input);

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
            'correct ***' => [
                'input' => '***',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'correct ---' => [
                'input' => '---',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'correct ___' => [
                'input' => '___',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'wrong characters +++' => [
                'input' => '+++',
                'output' => null,
                'render' => null
            ],
            'wrong characters ===' => [
                'input' => '===',
                'output' => null,
                'render' => null
            ],
            'not enough characters --' => [
                'input' => '--',
                'output' => null,
                'render' => null
            ],
            'not enough characters ==' => [
                'input' => '**',
                'output' => null,
                'render' => null
            ],
            'not enough characters __' => [
                'input' => '__',
                'output' => null,
                'render' => null
            ],
            'one spaces indent allowed' => [
                'input' => ' ***',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'two spaces indent allowed' => [
                'input' => '  ***',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'three spaces indent allowed' => [
                'input' => '   ***',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'four spaces too many' => [
                'input' => '    ***',
                'output' => null,
                'render' => null
            ],
            'more than three characters may be used' => [
                'input' => '_____________________________________',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'spaces allowed between characters #1' => [
                'input' => ' - - -',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'spaces allowed between characters #2' => [
                'input' => ' **  * ** * ** * **',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'spaces allowed between characters #3' => [
                'input' => '-     -      -      -',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'spaces allowed at the end' => [
                'input' => '- - - -    ',
                'output' => ThematicBreak::class,
                'render' => '<hr />'
            ],
            'no other characters may occur in the line #1' => [
                'input' => '_ _ _ _ a',
                'output' => null,
                'render' => null
            ],
            'no other characters may occur in the line #2' => [
                'input' => 'a------',
                'output' => null,
                'render' => null
            ],
            'no other characters may occur in the line #3' => [
                'input' => '---a---',
                'output' => null,
                'render' => null
            ]
        ];
    }
}
