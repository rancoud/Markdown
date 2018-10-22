<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Markdown;

/**
 * Class MarkdownTest.
 */
class MarkdownTest extends TestCase
{
    public function testConstruct()
    {
        new Markdown();
        static::assertTrue(true);
    }
}
