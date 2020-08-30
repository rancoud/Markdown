<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Markdown;

class MarkdownTest extends TestCase
{
    public function testConstruct(): void
    {
        new Markdown();
        static::assertTrue(true);
    }

    /**
     * @dataProvider data
     * @param $filename
     */
    public function testRender($filename): void
    {
        $dirpath = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;

        $input = file_get_contents($dirpath . $filename . '.md');
        $output = file_get_contents($dirpath . $filename . '.html');

        $markdown = new Markdown();

        static::assertSame($output, $markdown->render($input));
    }

    public function data(): array
    {
        $data = [];

        $dirpath = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR;
        $len = strlen($dirpath);
        $paths = glob($dirpath . '*.md');
        foreach ($paths as $path) {
            $name = substr($path, $len, -3);
            $data[$name] = ['name' => $name];
        }

        return $data;
    }
}
