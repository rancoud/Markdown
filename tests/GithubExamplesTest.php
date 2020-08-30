<?php

declare(strict_types=1);

namespace Rancoud\Markdown\Test;

use PHPUnit\Framework\TestCase;
use Rancoud\Markdown\Markdown;

class GithubExamplesTest extends TestCase
{
    /**
     * @dataProvider dataTabs
     * @dataProvider dataPrecedence
     * @dataProvider dataThematicBreaks
     * @dataProvider dataATXHeading
     * @dataProvider dataSetextHeadings
     * @dataProvider dataIndentedCodeBlocks
     * @dataProvider dataFencedCodeBlocks
     * @dataProvider dataHTMLBlocks
     * @dataProvider dataLinkReferenceDefinitions
     * @dataProvider dataParagraphs
     * @dataProvider dataBlankLines
     * @dataProvider dataTables
     * @dataProvider dataBlockQuotes
     * @dataProvider dataListItems
     * @dataProvider dataTaskListItems
     * @dataProvider dataList
     * @dataProvider dataBackslashEscapes
     * @dataProvider dataEntityAndNumericCharacterReferences
     * @dataProvider dataCodeSpans
     * @dataProvider dataEmphasisAndStrongEmphasis
     * @dataProvider dataStrikethrough
     * @dataProvider dataLinks
     * @dataProvider dataImages
     * @dataProvider dataAutolinks
     * @dataProvider dataRawHTML
     * @dataProvider dataDisallowedRawHTML
     * @dataProvider dataHardLineBreaks
     * @dataProvider dataSoftLineBreaks
     * @dataProvider dataTextualContent
     *
     * @param string $input
     * @param string $render
     */
    public function testExamples(string $input, string $render): void
    {
        static::assertSame($render, (new Markdown())->render($input));
    }

    public function dataTabs(): array
    {
        return [
            'https://github.github.com/gfm/#example-1' => [
                'input' =>  "\tfoo\tbaz\t\tbim",
                'render' => "<pre><code>foo\tbaz\t\tbim" . "\n" .
                            "</code></pre>",
            ],
            'https://github.github.com/gfm/#example-2' => [
                'input' =>  "  \tfoo\tbaz\t\tbim",
                'render' => "<pre><code>foo\tbaz\t\tbim" . "\n" .
                            "</code></pre>",
            ],
            'https://github.github.com/gfm/#example-3' => [
                'input' =>  "    a→a" . "\n" .
                            "    ὐ→a",
                'render' => "<pre><code>a→a" . "\n" .
                            "ὐ→a" . "\n" .
                            "</code></pre>",
            ],
            'https://github.github.com/gfm/#example-4' => [
                'input' =>  "  - foo" . "\n" .
                            "" . "\n" .
                            "\tbar" . "\n",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>",
            ],
            'https://github.github.com/gfm/#example-5' => [
                'input' =>  "- foo" . "\n" .
                            "" . "\n" .
                            "\t\tbar" . "\n",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code>  bar" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>",
            ],
            'https://github.github.com/gfm/#example-6' => [
                'input' => ">\t\tfoo",
                'render' => "<blockquote>" . "\n" .
                            "<pre><code>  foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "</blockquote>",
            ],
            'https://github.github.com/gfm/#example-7' => [
                'input' => "-\t\tfoo",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code>  foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>",
            ],
            'https://github.github.com/gfm/#example-8' => [
                'input'  => "    foo" . "\n" .
                            "\tbar",
                'render' => "<pre><code>foo" . "\n" .
                            "bar" . "\n" .
                            "</code></pre>",
            ],
            'https://github.github.com/gfm/#example-9' => [
                'input'  => " - foo" . "\n" .
                            "   - bar" . "\n" .
                            "\t - baz",
                'render' => "<ul>" . "\n" .
                            "<li>foo" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar" . "\n" .
                            "<ul>" . "\n" .
                            "<li>baz</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>",
            ],
            'https://github.github.com/gfm/#example-10' => [
                'input' => "#\tFoo",
                'render' => "<h1>Foo</h1>",
            ],
            'https://github.github.com/gfm/#example-11' => [
                'input' => "*\t*\t*\t",
                'render' => "<hr />",
            ]
        ];
    }

    public function dataPrecedence(): array
    {
        return [
            'https://github.github.com/gfm/#example-12' => [
                'input' =>  "- `one" . "\n" .
                            "- two`",
                'render' => "<ul>" . "\n" .
                            "<li>`one</li>" . "\n" .
                            "<li>two`</li>" . "\n" .
                            "</ul>",
            ],
        ];
    }

    public function dataThematicBreaks(): array
    {
        return [
            'https://github.github.com/gfm/#example-13' => [
                'input' =>  "***" . "\n" .
                            "---" . "\n" .
                            "___",
                'render' => "<hr />" . "\n" .
                            "<hr />" . "\n" .
                            "<hr />",
            ],
            'https://github.github.com/gfm/#example-14' => [
                'input' =>  "+++",
                'render' => "<p>+++</p>",
            ],
            'https://github.github.com/gfm/#example-15' => [
                'input' =>  "===",
                'render' => "<p>===</p>",
            ],
            'https://github.github.com/gfm/#example-16' => [
                'input' =>  "--" . "\n" .
                            "**" . "\n" .
                            "__",
                'render' => "<p>--" . "\n" .
                            "**" . "\n" .
                            "__</p>",
            ],
            'https://github.github.com/gfm/#example-17' => [
                'input' =>  " ***" . "\n" .
                            "  ***" . "\n" .
                            "   ***",
                'render' => "<hr />" . "\n" .
                            "<hr />" . "\n" .
                            "<hr />",
            ],
            'https://github.github.com/gfm/#example-18' => [
                'input' =>  "    ***",
                'render' => "<pre><code>***" . "\n" .
                            "</code></pre>",
            ],
            'https://github.github.com/gfm/#example-19' => [
                'input' =>  "Foo" . "\n" .
                            "    ***",
                'render' => "<p>Foo" . "\n" .
                            "***</p>",
            ],
            'https://github.github.com/gfm/#example-20' => [
                'input' =>  "_____________________________________",
                'render' => "<hr />",
            ],
            'https://github.github.com/gfm/#example-21' => [
                'input' =>  " - - -",
                'render' => "<hr />",
            ],
            'https://github.github.com/gfm/#example-22' => [
                'input' =>  " **  * ** * ** * **",
                'render' => "<hr />",
            ],
            'https://github.github.com/gfm/#example-23' => [
                'input' =>  "-     -      -      -",
                'render' => "<hr />",
            ],
            'https://github.github.com/gfm/#example-24' => [
                'input' =>  " - - -    ",
                'render' => "<hr />",
            ],
            'https://github.github.com/gfm/#example-25' => [
                'input' =>  "_ _ _ _ a" . "\n" .
                            "" . "\n" .
                            "a------" . "\n" .
                            "" . "\n" .
                            "---a---",
                'render' => "<p>_ _ _ _ a</p>" . "\n" .
                            "<p>a------</p>" . "\n" .
                            "<p>---a---</p>",
            ],
            'https://github.github.com/gfm/#example-26' => [
                'input' =>  " *-*",
                'render' => "<p><em>-</em></p>",
            ],
            'https://github.github.com/gfm/#example-27' => [
                'input' =>  "- foo" . "\n" .
                            "***" . "\n" .
                            "- bar",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<hr />" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>",
            ],
            'https://github.github.com/gfm/#example-28' => [
                'input' =>  "Foo" . "\n" .
                            "***" . "\n" .
                            "bar",
                'render' => "<p>Foo</p>" . "\n" .
                            "<hr />" . "\n" .
                            "<p>bar</p>",
            ],
            'https://github.github.com/gfm/#example-29' => [
                'input' =>  "Foo" . "\n" .
                            "---" . "\n" .
                            "bar",
                'render' => "<h2>Foo</h2>" . "\n" .
                            "<p>bar</p>",
            ],
            'https://github.github.com/gfm/#example-30' => [
                'input' =>  "* Foo" . "\n" .
                            "* * *" . "\n" .
                            "* Bar",
                'render' => "<ul>" . "\n" .
                            "<li>Foo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<hr />" . "\n" .
                            "<ul>" . "\n" .
                            "<li>Bar</li>" . "\n" .
                            "</ul>",
            ],
            'https://github.github.com/gfm/#example-31' => [
                'input' =>  "- Foo" . "\n" .
                            "- * * *",
                'render' => "<ul>" . "\n" .
                            "<li>Foo</li>" . "\n" .
                            "<li>" . "\n" .
                            "<hr />" . "\n" .
                            "</li>" . "\n" .
                            "</ul>",
            ]
        ];
    }

    public function dataATXHeading(): array
    {
        return [
            'https://github.github.com/gfm/#example-32' => [
                'input' =>  "# foo" . "\n" .
                            "## foo" . "\n" .
                            "### foo" . "\n" .
                            "#### foo" . "\n" .
                            "##### foo" . "\n" .
                            "###### foo",
                'render' => "<h1>foo</h1>" . "\n" .
                            "<h2>foo</h2>" . "\n" .
                            "<h3>foo</h3>" . "\n" .
                            "<h4>foo</h4>" . "\n" .
                            "<h5>foo</h5>" . "\n" .
                            "<h6>foo</h6>"
            ],
            'https://github.github.com/gfm/#example-33' => [
                'input' =>  "####### foo",
                'render' => "<p>####### foo</p>"
            ],
            'https://github.github.com/gfm/#example-34' => [
                'input' =>  "#5 bolt" . "\n" .
                            "" . "\n" .
                            "#hashtag",
                'render' => "<p>#5 bolt</p>" . "\n" .
                            "<p>#hashtag</p>"
            ],
            'https://github.github.com/gfm/#example-35' => [
                'input' =>  "\## foo",
                'render' => "<p>## foo</p>"
            ],
            'https://github.github.com/gfm/#example-36' => [
                'input' =>  "# foo *bar* \*baz\*",
                'render' => "<h1>foo <em>bar</em> *baz*</h1>"
            ],
            'https://github.github.com/gfm/#example-37' => [
                'input' =>  "#                  foo                     ",
                'render' => "<h1>foo</h1>"
            ],
            'https://github.github.com/gfm/#example-38' => [
                'input' =>  " ### foo" . "\n" .
                            "  ## foo" . "\n" .
                            "   # foo",
                'render' => "<h3>foo</h3>" . "\n" .
                            "<h2>foo</h2>" . "\n" .
                            "<h1>foo</h1>"
            ],
            'https://github.github.com/gfm/#example-39' => [
                'input' =>  "    # foo",
                'render' => "<pre><code># foo" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-40' => [
                'input' =>  "foo" . "\n" .
                            "    # bar",
                'render' => "<p>foo" . "\n" .
                            "# bar</p>"
            ],
            'https://github.github.com/gfm/#example-41' => [
                'input' =>  "## foo ##" . "\n" .
                            "  ###   bar    ###",
                'render' => "<h2>foo</h2>" . "\n" .
                            "<h3>bar</h3>"
            ],
            'https://github.github.com/gfm/#example-42' => [
                'input' =>  "# foo ##################################" . "\n" .
                            "##### foo ##",
                'render' => "<h1>foo</h1>" . "\n" .
                            "<h5>foo</h5>"
            ],
            'https://github.github.com/gfm/#example-43' => [
                'input' =>  "### foo ###     ",
                'render' => "<h3>foo</h3>"
            ],
            'https://github.github.com/gfm/#example-44' => [
                'input' =>  "### foo ### b",
                'render' => "<h3>foo ### b</h3>"
            ],
            'https://github.github.com/gfm/#example-45' => [
                'input' =>  "# foo#",
                'render' => "<h1>foo#</h1>"
            ],
            'https://github.github.com/gfm/#example-46' => [
                'input' =>  "### foo \###" . "\n" .
                            "## foo #\##" . "\n" .
                            "# foo \#",
                'render' => "<h3>foo ###</h3>" . "\n" .
                            "<h2>foo ###</h2>" . "\n" .
                            "<h1>foo #</h1>"
            ],
            'https://github.github.com/gfm/#example-47' => [
                'input' =>  "****" . "\n" .
                            "## foo" . "\n" .
                            "****",
                'render' => "<hr />" . "\n" .
                            "<h2>foo</h2>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-48' => [
                'input' =>  "Foo bar" . "\n" .
                            "# baz" . "\n" .
                            "Bar foo",
                'render' => "<p>Foo bar</p>" . "\n" .
                            "<h1>baz</h1>" . "\n" .
                            "<p>Bar foo</p>"
            ],
            'https://github.github.com/gfm/#example-49' => [
                'input' =>  "## " . "\n" .
                            "#" . "\n" .
                            "### ###",
                'render' => "<h2></h2>" . "\n" .
                            "<h1></h1>" . "\n" .
                            "<h3></h3>"
            ],
        ];
    }

    public function dataSetextHeadings(): array
    {
        return [
            'https://github.github.com/gfm/#example-50' => [
                'input' =>  "Foo *bar*" . "\n" .
                            "=========" . "\n" .
                            "" . "\n" .
                            "Foo *bar*" . "\n" .
                            "---------",
                'render' => "<h1>Foo <em>bar</em></h1>" . "\n" .
                            "<h2>Foo <em>bar</em></h2>"
            ],
            'https://github.github.com/gfm/#example-51' => [
                'input' =>  "Foo *bar" . "\n" .
                            "baz*" . "\n" .
                            "====",
                'render' => "<h1>Foo <em>bar" . "\n" .
                            "baz</em></h1>"
            ],
            'https://github.github.com/gfm/#example-52' => [
                'input' =>  "  Foo *bar" . "\n" .
                            "baz*\t" . "\n" .
                            "====",
                'render' => "<h1>Foo <em>bar" . "\n" .
                            "baz</em></h1>"
            ],
            'https://github.github.com/gfm/#example-53' => [
                'input' =>  "Foo" . "\n" .
                            "-------------------------" . "\n" .
                            "" . "\n" .
                            "Foo" . "\n" .
                            "=",
                'render' => "<h2>Foo</h2>" . "\n" .
                            "<h1>Foo</h1>"
            ],
            'https://github.github.com/gfm/#example-54' => [
                'input' =>  "   Foo" . "\n" .
                            "---" . "\n" .
                            "" . "\n" .
                            "  Foo" . "\n" .
                            "-----" . "\n" .
                            "" . "\n" .
                            "  Foo" . "\n" .
                            "  ===",
                'render' => "<h2>Foo</h2>" . "\n" .
                            "<h2>Foo</h2>" . "\n" .
                            "<h1>Foo</h1>"
            ],
            'https://github.github.com/gfm/#example-55' => [
                'input' =>  "    Foo" . "\n" .
                            "    ---" . "\n" .
                            "" . "\n" .
                            "    Foo" . "\n" .
                            "---",
                'render' => "<pre><code>Foo" . "\n" .
                            "---" . "\n" .
                            "" . "\n" .
                            "Foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-56' => [
                'input' =>  "Foo" . "\n" .
                            "   ----      ",
                'render' => "<h2>Foo</h2>"
            ],
            'https://github.github.com/gfm/#example-57' => [
                'input' =>  "Foo" . "\n" .
                            "    ---",
                'render' => "<p>Foo" . "\n" .
                            "---</p>"
            ],
            'https://github.github.com/gfm/#example-58' => [
                'input' =>  "Foo" . "\n" .
                            "= =" . "\n" .
                            "" . "\n" .
                            "Foo" . "\n" .
                            "--- -",
                'render' => "<p>Foo" . "\n" .
                            "= =</p>" . "\n" .
                            "<p>Foo</p>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-59' => [
                'input' =>  "Foo  " . "\n" .
                            "-----",
                'render' => "<h2>Foo</h2>"
            ],
            'https://github.github.com/gfm/#example-60' => [
                'input' =>  "Foo\\" . "\n" .
                            "----",
                'render' => "<h2>Foo\</h2>"
            ],
            'https://github.github.com/gfm/#example-61' => [
                'input' =>  "`Foo" . "\n" .
                            "----" . "\n" .
                            "`" . "\n" .
                            "" . "\n" .
                            "<a title=\"a lot" . "\n" .
                            "---" . "\n" .
                            "of dashes\"/>",
                'render' => "<h2>`Foo</h2>" . "\n" .
                            "<p>`</p>" . "\n" .
                            "<h2>&lt;a title=&quot;a lot</h2>" . "\n" .
                            "<p>of dashes&quot;/&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-62' => [
                'input' =>  "> Foo" . "\n" .
                            "---",
                'render' => "<blockquote>" . "\n" .
                            "<p>Foo</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-63' => [
                'input' =>  "> foo" . "\n" .
                            "bar" . "\n" .
                            "===",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo" . "\n" .
                            "bar" . "\n" .
                            "===</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-64' => [
                'input' =>  "- Foo" . "\n" .
                            "---",
                'render' => "<ul>" . "\n" .
                            "<li>Foo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-65' => [
                'input' =>  "Foo" . "\n" .
                            "Bar" . "\n" .
                            "---",
                'render' => "<h2>Foo" . "\n" .
                            "Bar</h2>"
            ],
            'https://github.github.com/gfm/#example-66' => [
                'input' =>  "---" . "\n" .
                            "Foo" . "\n" .
                            "---" . "\n" .
                            "Bar" . "\n" .
                            "---" . "\n" .
                            "Baz",
                'render' => "<hr />" . "\n" .
                            "<h2>Foo</h2>" . "\n" .
                            "<h2>Bar</h2>" . "\n" .
                            "<p>Baz</p>"
            ],
            'https://github.github.com/gfm/#example-67' => [
                'input' =>  "" . "\n" .
                            "====",
                'render' => "<p>====</p>"
            ],
            'https://github.github.com/gfm/#example-68' => [
                'input' =>  "---" . "\n" .
                            "---",
                'render' => "<hr />" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-69' => [
                'input' =>  "- foo" . "\n" .
                            "-----",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-70' => [
                'input' =>  "    foo" . "\n" .
                            "---",
                'render' => "<pre><code>foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-71' => [
                'input' =>  "> foo" . "\n" .
                            "-----",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-72' => [
                'input' =>  "\> foo" . "\n" .
                            "------",
                'render' => "<h2>&gt; foo</h2>"
            ],
            'https://github.github.com/gfm/#example-73' => [
                'input' =>  "Foo" . "\n" .
                            "" . "\n" .
                            "bar" . "\n" .
                            "---" . "\n" .
                            "baz",
                'render' => "<p>Foo</p>" . "\n" .
                            "<h2>bar</h2>" . "\n" .
                            "<p>baz</p>"
            ],
            'https://github.github.com/gfm/#example-74' => [
                'input' =>  "Foo" . "\n" .
                            "bar" . "\n" .
                            "" . "\n" .
                            "---" . "\n" .
                            "" . "\n" .
                            "baz",
                'render' => "<p>Foo" . "\n" .
                            "bar</p>" . "\n" .
                            "<hr />" . "\n" .
                            "<p>baz</p>"
            ],
            'https://github.github.com/gfm/#example-75' => [
                'input' =>  "Foo" . "\n" .
                            "bar" . "\n" .
                            "* * *" . "\n" .
                            "baz",
                'render' => "<p>Foo" . "\n" .
                            "bar</p>" . "\n" .
                            "<hr />" . "\n" .
                            "<p>baz</p>"
            ],
            'https://github.github.com/gfm/#example-76' => [
                'input' =>  "Foo" . "\n" .
                            "bar" . "\n" .
                            "\---" . "\n" .
                            "baz",
                'render' => "<p>Foo" . "\n" .
                            "bar" . "\n" .
                            "---" . "\n" .
                            "baz</p>"
            ],
        ];
    }

    public function dataIndentedCodeBlocks(): array
    {
        return [
            'https://github.github.com/gfm/#example-77' => [
                'input' =>  "    a simple" . "\n" .
                            "      indented code block",
                'render' => "<pre><code>a simple" . "\n" .
                            "  indented code block" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-78' => [
                'input' =>  "  - foo" . "\n" .
                            "" . "\n" .
                            "    bar",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-79' => [
                'input' =>  "1.  foo" . "\n" .
                            "" . "\n" .
                            "    - bar",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-80' => [
                'input' =>  "    <a/>" . "\n" .
                            "    *hi*" . "\n" .
                            "" . "\n" .
                            "    - one",
                'render' => "<pre><code>&lt;a/&gt;" . "\n" .
                            "*hi*" . "\n" .
                            "" . "\n" .
                            "- one" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-81' => [
                'input' =>  "    chunk1" . "\n" .
                            "" . "\n" .
                            "    chunk2" . "\n" .
                            "  " . "\n" .
                            " " . "\n" .
                            " " . "\n" .
                            "    chunk3",
                'render' => "<pre><code>chunk1" . "\n" .
                            "" . "\n" .
                            "chunk2" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "chunk3" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-82' => [
                'input' =>  "    chunk1" . "\n" .
                            "      " . "\n" .
                            "      chunk2",
                'render' => "<pre><code>chunk1" . "\n" .
                            "  " . "\n" .
                            "  chunk2" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-83' => [
                'input' =>  "Foo" . "\n" .
                            "    bar",
                'render' => "<p>Foo" . "\n" .
                            "bar</p>"
            ],
            'https://github.github.com/gfm/#example-84' => [
                'input' =>  "    foo" . "\n" .
                            "bar",
                'render' => "<pre><code>foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>bar</p>"
            ],
            'https://github.github.com/gfm/#example-85' => [
                'input' =>  "# Heading" . "\n" .
                            "    foo" . "\n" .
                            "Heading" . "\n" .
                            "------" . "\n" .
                            "    foo" . "\n" .
                            "----",
                'render' => "<h1>Heading</h1>" . "\n" .
                            "<pre><code>foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "<h2>Heading</h2>" . "\n" .
                            "<pre><code>foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-86' => [
                'input' =>  "        foo" . "\n" .
                            "    bar",
                'render' => "<pre><code>    foo" . "\n" .
                            "bar" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-87' => [
                'input' =>  "" . "\n" .
                            "    " . "\n" .
                            "    foo" . "\n" .
                            "    ",
                'render' => "<pre><code>foo" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-88' => [
                'input' =>  "    foo  ",
                'render' => "<pre><code>foo  " . "\n" .
                            "</code></pre>"
            ],
        ];
    }

    public function dataFencedCodeBlocks(): array
    {
        return [
            'https://github.github.com/gfm/#example-89' => [
                'input' =>  "```" . "\n" .
                            "<" . "\n" .
                            " >" . "\n" .
                            "```",
                'render' => "<pre><code>&lt;" . "\n" .
                            " &gt;" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-90' => [
                'input' =>  "~~~" . "\n" .
                            "<" . "\n" .
                            " >" . "\n" .
                            "~~~",
                'render' => "<pre><code>&lt;" . "\n" .
                            " &gt;" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-91' => [
                'input' =>  "``" . "\n" .
                            "foo" . "\n" .
                            "``",
                'render' => "<p><code>foo</code></p>"
            ],
            'https://github.github.com/gfm/#example-92' => [
                'input' =>  "```" . "\n" .
                            "aaa" . "\n" .
                            "~~~" . "\n" .
                            "```",
                'render' => "<pre><code>aaa" . "\n" .
                            "~~~" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-93' => [
                'input' =>  "~~~" . "\n" .
                            "aaa" . "\n" .
                            "```" . "\n" .
                            "~~~",
                'render' => "<pre><code>aaa" . "\n" .
                            "```" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-94' => [
                'input' =>  "````" . "\n" .
                            "aaa" . "\n" .
                            "```" . "\n" .
                            "``````",
                'render' => "<pre><code>aaa" . "\n" .
                            "```" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-95' => [
                'input' =>  "~~~~" . "\n" .
                            "aaa" . "\n" .
                            "~~~" . "\n" .
                            "~~~~",
                'render' => "<pre><code>aaa" . "\n" .
                            "~~~" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-96' => [
                'input' =>  "```",
                'render' => "<pre><code></code></pre>"
            ],
            'https://github.github.com/gfm/#example-97' => [
                'input' =>  "`````" . "\n" .
                            "" . "\n" .
                            "```" . "\n" .
                            "aaa",
                'render' => "<pre><code>" . "\n" .
                            "```" . "\n" .
                            "aaa" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-98' => [
                'input' =>  "> ```" . "\n" .
                            "> aaa" . "\n" .
                            "" . "\n" .
                            "bbb",
                'render' => "<blockquote>" . "\n" .
                            "<pre><code>aaa" . "\n" .
                            "</code></pre>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<p>bbb</p>"
            ],
            'https://github.github.com/gfm/#example-99' => [
                'input' =>  "```" . "\n" .
                            "" . "\n" .
                            "  " . "\n" .
                            "```",
                'render' => "<pre><code>" . "\n" .
                            "  " . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-100' => [
                'input' =>  "```" . "\n" .
                            "```",
                'render' => "<pre><code></code></pre>"
            ],
            'https://github.github.com/gfm/#example-101' => [
                'input' =>  " ```" . "\n" .
                            " aaa" . "\n" .
                            "aaa" . "\n" .
                            "```",
                'render' => "<pre><code>aaa" . "\n" .
                            "aaa" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-102' => [
                'input' =>  "  ```" . "\n" .
                            "aaa" . "\n" .
                            "  aaa" . "\n" .
                            "aaa" . "\n" .
                            "  ```",
                'render' => "<pre><code>aaa" . "\n" .
                            "aaa" . "\n" .
                            "aaa" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-103' => [
                'input' =>  "   ```" . "\n" .
                            "   aaa" . "\n" .
                            "    aaa" . "\n" .
                            "  aaa" . "\n" .
                            "   ```",
                'render' => "<pre><code>aaa" . "\n" .
                            " aaa" . "\n" .
                            "aaa" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-104' => [
                'input' =>  "    ```" . "\n" .
                            "    aaa" . "\n" .
                            "    ```",
                'render' => "<pre><code>```" . "\n" .
                            "aaa" . "\n" .
                            "```" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-105' => [
                'input' =>  "```" . "\n" .
                            "aaa" . "\n" .
                            "  ```",
                'render' => "<pre><code>aaa" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-106' => [
                'input' =>  "   ```" . "\n" .
                            "aaa" . "\n" .
                            "  ```",
                'render' => "<pre><code>aaa" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-107' => [
                'input' =>  "```" . "\n" .
                            "aaa" . "\n" .
                            "    ```",
                'render' => "<pre><code>aaa" . "\n" .
                            "    ```" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-108' => [
                'input' =>  "``` ```" . "\n" .
                            "aaa",
                'render' => "<p><code> </code>" . "\n" .
                            "aaa</p>"
            ],
            'https://github.github.com/gfm/#example-109' => [
                'input' =>  "~~~~~~" . "\n" .
                            "aaa" . "\n" .
                            "~~~ ~~",
                'render' => "<pre><code>aaa" . "\n" .
                            "~~~ ~~" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-110' => [
                'input' =>  "foo" . "\n" .
                            "```" . "\n" .
                            "bar" . "\n" .
                            "```" . "\n" .
                            "baz",
                'render' => "<p>foo</p>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>baz</p>"
            ],
            'https://github.github.com/gfm/#example-111' => [
                'input' =>  "foo" . "\n" .
                            "---" . "\n" .
                            "~~~" . "\n" .
                            "bar" . "\n" .
                            "~~~" . "\n" .
                            "# baz",
                'render' => "<h2>foo</h2>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "</code></pre>" . "\n" .
                            "<h1>baz</h1>"
            ],
            'https://github.github.com/gfm/#example-112' => [
                'input' =>  "```ruby" . "\n" .
                            "def foo(x)" . "\n" .
                            "  return 3" . "\n" .
                            "end" . "\n" .
                            "```",
                'render' => "<pre><code class=\"language-ruby\">def foo(x)" . "\n" .
                            "  return 3" . "\n" .
                            "end" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-113' => [
                'input' =>  "~~~~    ruby startline=3 $%@#$" . "\n" .
                            "def foo(x)" . "\n" .
                            "  return 3" . "\n" .
                            "end" . "\n" .
                            "~~~~~~~",
                'render' => "<pre><code class=\"language-ruby\">def foo(x)" . "\n" .
                            "  return 3" . "\n" .
                            "end" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-114' => [
                'input' =>  "````;" . "\n" .
                            "````",
                'render' => "<pre><code class=\"language-;\"></code></pre>"
            ],
            'https://github.github.com/gfm/#example-115' => [
                'input' =>  "``` aa ```" . "\n" .
                            "foo",
                'render' => "<p><code>aa</code>" . "\n" .
                            "foo</p>"
            ],
            'https://github.github.com/gfm/#example-116' => [
                'input' =>  "~~~ aa ``` ~~~" . "\n" .
                            "foo" . "\n" .
                            "~~~",
                'render' => "<pre><code class=\"language-aa\">foo" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-117' => [
                'input' =>  "```" . "\n" .
                            "``` aaa" . "\n" .
                            "```",
                'render' => "<pre><code>``` aaa" . "\n" .
                            "</code></pre>"
            ],
        ];
    }

    public function dataHTMLBlocks(): array
    {
        return [
            'https://github.github.com/gfm/#example-118' => [
                'input' =>  "<table><tr><td>" . "\n" .
                            "<pre>" . "\n" .
                            "**Hello**," . "\n" .
                            "" . "\n" .
                            "_world_." . "\n" .
                            "</pre>" . "\n" .
                            "</td></tr></table>",
                'render' => "<table><tr><td>" . "\n" .
                            "<pre>" . "\n" .
                            "**Hello**," . "\n" .
                            "<p><em>world</em>." . "\n" .
                            "</pre></p>" . "\n" .
                            "</td></tr></table>"
            ],
            'https://github.github.com/gfm/#example-119' => [
                'input' =>  "<table>" . "\n" .
                            "  <tr>" . "\n" .
                            "    <td>" . "\n" .
                            "           hi" . "\n" .
                            "    </td>" . "\n" .
                            "  </tr>" . "\n" .
                            "</table>" . "\n" .
                            "" . "\n" .
                            "okay.",
                'render' => "<table>" . "\n" .
                            "  <tr>" . "\n" .
                            "    <td>" . "\n" .
                            "           hi" . "\n" .
                            "    </td>" . "\n" .
                            "  </tr>" . "\n" .
                            "</table>" . "\n" .
                            "<p>okay.</p>"
            ],
            'https://github.github.com/gfm/#example-120' => [
                'input' =>  " <div>" . "\n" .
                            "  *hello*" . "\n" .
                            "         <foo><a>",
                'render' => " <div>" . "\n" .
                            "  *hello*" . "\n" .
                            "         <foo><a>"
            ],
            'https://github.github.com/gfm/#example-121' => [
                'input' =>  "</div>" . "\n" .
                            "*foo*",
                'render' => "</div>" . "\n" .
                            "*foo*"
            ],
            'https://github.github.com/gfm/#example-122' => [
                'input' =>  "<DIV CLASS=\"foo\">" . "\n" .
                            "" . "\n" .
                            "*Markdown*" . "\n" .
                            "" . "\n" .
                            "</DIV>",
                'render' => "<DIV CLASS=\"foo\">" . "\n" .
                            "<p><em>Markdown</em></p>" . "\n" .
                            "</DIV>"
            ],
            'https://github.github.com/gfm/#example-123' => [
                'input' =>  "<div id=\"foo\"" . "\n" .
                            "  class=\"bar\">" . "\n" .
                            "</div>",
                'render' => "<div id=\"foo\"" . "\n" .
                            "  class=\"bar\">" . "\n" .
                            "</div>"
            ],
            'https://github.github.com/gfm/#example-124' => [
                'input' =>  "<div id=\"foo\" class=\"bar" . "\n" .
                            "  baz\">" . "\n" .
                            "</div>",
                'render' => "<div id=\"foo\" class=\"bar" . "\n" .
                            "  baz\">" . "\n" .
                            "</div>"
            ],
            'https://github.github.com/gfm/#example-125' => [
                'input' =>  "<div>" . "\n" .
                            "*foo*" . "\n" .
                            "" . "\n" .
                            "*bar*",
                'render' => "<div>" . "\n" .
                            "*foo*" . "\n" .
                            "<p><em>bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-126' => [
                'input' =>  "<div id=\"foo\"" . "\n" .
                            "*hi*",
                'render' => "<div id=\"foo\"" . "\n" .
                            "*hi*"
            ],
            'https://github.github.com/gfm/#example-127' => [
                'input' =>  "<div class" . "\n" .
                            "foo",
                'render' => "<div class" . "\n" .
                            "foo"
            ],
            'https://github.github.com/gfm/#example-128' => [
                'input' =>  "<div *???-&&&-<---" . "\n" .
                            "*foo*",
                'render' => "<div *???-&&&-<---" . "\n" .
                            "*foo*"
            ],
            'https://github.github.com/gfm/#example-129' => [
                'input' =>  "<div><a href=\"bar\">*foo*</a></div>",
                'render' => "<div><a href=\"bar\">*foo*</a></div>"
            ],
            'https://github.github.com/gfm/#example-130' => [
                'input' =>  "<table><tr><td>" . "\n" .
                            "foo" . "\n" .
                            "</td></tr></table>",
                'render' => "<table><tr><td>" . "\n" .
                            "foo" . "\n" .
                            "</td></tr></table>"
            ],
            'https://github.github.com/gfm/#example-131' => [
                'input' =>  "<div></div>" . "\n" .
                            "``` c" . "\n" .
                            "int x = 33;" . "\n" .
                            "```",
                'render' => "<div></div>" . "\n" .
                            "``` c" . "\n" .
                            "int x = 33;" . "\n" .
                            "```"
            ],
            'https://github.github.com/gfm/#example-132' => [
                'input' =>  "<a href=\"foo\">" . "\n" .
                            "*bar*" . "\n" .
                            "</a>",
                'render' => "<a href=\"foo\">" . "\n" .
                            "*bar*" . "\n" .
                            "</a>"
            ],
            'https://github.github.com/gfm/#example-133' => [
                'input' =>  "<Warning>" . "\n" .
                            "*bar*" . "\n" .
                            "</Warning>",
                'render' => "<Warning>" . "\n" .
                            "*bar*" . "\n" .
                            "</Warning>"
            ],
            'https://github.github.com/gfm/#example-134' => [
                'input' =>  "<i class=\"foo\">" . "\n" .
                            "*bar*" . "\n" .
                            "</i>",
                'render' => "<i class=\"foo\">" . "\n" .
                            "*bar*" . "\n" .
                            "</i>"
            ],
            'https://github.github.com/gfm/#example-135' => [
                'input' =>  "</ins>" . "\n" .
                            "*bar*",
                'render' => "</ins>" . "\n" .
                            "*bar*"
            ],
            'https://github.github.com/gfm/#example-136' => [
                'input' =>  "<del>" . "\n" .
                            "*foo*" . "\n" .
                            "</del>",
                'render' => "<del>" . "\n" .
                            "*foo*" . "\n" .
                            "</del>"
            ],
            'https://github.github.com/gfm/#example-137' => [
                'input' =>  "<del>" . "\n" .
                            "" . "\n" .
                            "*foo*" . "\n" .
                            "" . "\n" .
                            "</del>",
                'render' => "<del>" . "\n" .
                            "<p><em>foo</em></p>" . "\n" .
                            "</del>"
            ],
            'https://github.github.com/gfm/#example-138' => [
                'input' =>  "<del>*foo*</del>",
                'render' => "<p><del><em>foo</em></del></p>"
            ],
            'https://github.github.com/gfm/#example-139' => [
                'input' =>  "<pre language=\"haskell\"><code>" . "\n" .
                            "import Text.HTML.TagSoup" . "\n" .
                            "" . "\n" .
                            "main :: IO ()" . "\n" .
                            "main = print $ parseTags tags" . "\n" .
                            "</code></pre>" . "\n" .
                            "okay",
                'render' => "<pre language=\"haskell\"><code>" . "\n" .
                            "import Text.HTML.TagSoup" . "\n" .
                            "" . "\n" .
                            "main :: IO ()" . "\n" .
                            "main = print $ parseTags tags" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>okay</p>"
            ],
            'https://github.github.com/gfm/#example-140' => [
                'input' =>  "<script type=\"text/javascript\">" . "\n" .
                            "// JavaScript example" . "\n" .
                            "" . "\n" .
                            "document.getElementById(\"demo\").innerHTML = \"Hello JavaScript!\";" . "\n" .
                            "</script>" . "\n" .
                            "okay",
                'render' => "<script type=\"text/javascript\">" . "\n" .
                            "// JavaScript example" . "\n" .
                            "" . "\n" .
                            "document.getElementById(\"demo\").innerHTML = \"Hello JavaScript!\";" . "\n" .
                            "</script>" . "\n" .
                            "<p>okay</p>"
            ],
            'https://github.github.com/gfm/#example-141' => [
                'input' =>  "<style" . "\n" .
                            "  type=\"text/css\">" . "\n" .
                            "h1 {color:red;}" . "\n" .
                            "" . "\n" .
                            "p {color:blue;}" . "\n" .
                            "</style>" . "\n" .
                            "okay",
                'render' => "<style" . "\n" .
                            "  type=\"text/css\">" . "\n" .
                            "h1 {color:red;}" . "\n" .
                            "" . "\n" .
                            "p {color:blue;}" . "\n" .
                            "</style>" . "\n" .
                            "<p>okay</p>"
            ],
            'https://github.github.com/gfm/#example-142' => [
                'input' =>  "<style" . "\n" .
                            "  type=\"text/css\">" . "\n" .
                            "" . "\n" .
                            "foo",
                'render' => "<style" . "\n" .
                            "  type=\"text/css\">" . "\n" .
                            "" . "\n" .
                            "foo"
            ],
            'https://github.github.com/gfm/#example-143' => [
                'input' =>  "> <div>" . "\n" .
                            "> foo" . "\n" .
                            "" . "\n" .
                            "bar",
                'render' => "<blockquote>" . "\n" .
                            "<div>" . "\n" .
                            "foo" . "\n" .
                            "</blockquote>" . "\n" .
                            "<p>bar</p>"
            ],
            'https://github.github.com/gfm/#example-144' => [
                'input' =>  "- <div>" . "\n" .
                            "- foo",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<div>" . "\n" .
                            "</li>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-145' => [
                'input' =>  "<style>p{color:red;}</style>" . "\n" .
                            "*foo*",
                'render' => "<style>p{color:red;}</style>" . "\n" .
                            "<p><em>foo</em></p>"
            ],
            'https://github.github.com/gfm/#example-146' => [
                'input' =>  "<!-- foo -->*bar*" . "\n" .
                            "*baz*",
                'render' => "<!-- foo -->*bar*" . "\n" .
                            "<p><em>baz</em></p>"
            ],
            'https://github.github.com/gfm/#example-147' => [
                'input' =>  "<script>" . "\n" .
                            "foo" . "\n" .
                            "</script>1. *bar*",
                'render' => "<script>" . "\n" .
                            "foo" . "\n" .
                            "</script>1. *bar*"
            ],
            'https://github.github.com/gfm/#example-148' => [
                'input' =>  "<!-- Foo" . "\n" .
                            "" . "\n" .
                            "bar" . "\n" .
                            "   baz -->" . "\n" .
                            "okay",
                'render' => "<!-- Foo" . "\n" .
                            "" . "\n" .
                            "bar" . "\n" .
                            "   baz -->" . "\n" .
                            "<p>okay</p>"
            ],
            'https://github.github.com/gfm/#example-149' => [
                'input' =>  "<?php" . "\n" .
                            "" . "\n" .
                            "  echo '>';" . "\n" .
                            "" . "\n" .
                            "?>" . "\n" .
                            "okay",
                'render' => "<?php" . "\n" .
                            "" . "\n" .
                            "  echo '>';" . "\n" .
                            "" . "\n" .
                            "?>" . "\n" .
                            "<p>okay</p>"
            ],
            'https://github.github.com/gfm/#example-150' => [
                'input' =>  "<!DOCTYPE html>",
                'render' => "<!DOCTYPE html>"
            ],
            'https://github.github.com/gfm/#example-151' => [
                'input' =>  "<![CDATA[" . "\n" .
                            "function matchwo(a,b)" . "\n" .
                            "{" . "\n" .
                            "  if (a < b && a < 0) then {" . "\n" .
                            "    return 1;" . "\n" .
                            "" . "\n" .
                            "  } else {" . "\n" .
                            "" . "\n" .
                            "    return 0;" . "\n" .
                            "  }" . "\n" .
                            "}" . "\n" .
                            "]]>" . "\n" .
                            "okay",
                'render' => "<![CDATA[" . "\n" .
                            "function matchwo(a,b)" . "\n" .
                            "{" . "\n" .
                            "  if (a < b && a < 0) then {" . "\n" .
                            "    return 1;" . "\n" .
                            "" . "\n" .
                            "  } else {" . "\n" .
                            "" . "\n" .
                            "    return 0;" . "\n" .
                            "  }" . "\n" .
                            "}" . "\n" .
                            "]]>" . "\n" .
                            "<p>okay</p>"
            ],
            'https://github.github.com/gfm/#example-152' => [
                'input' =>  "  <!-- foo -->" . "\n" .
                            "" . "\n" .
                            "    <!-- foo -->",
                'render' => "  <!-- foo -->" . "\n" .
                            "<pre><code>&lt;!-- foo --&gt;" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-153' => [
                'input' =>  "  <div>" . "\n" .
                            "" . "\n" .
                            "    <div>",
                'render' => "  <div>" . "\n" .
                            "<pre><code>&lt;div&gt;" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-154' => [
                'input' =>  "Foo" . "\n" .
                            "<div>" . "\n" .
                            "bar" . "\n" .
                            "</div>",
                'render' => "<p>Foo</p>" . "\n" .
                            "<div>" . "\n" .
                            "bar" . "\n" .
                            "</div>"
            ],
            'https://github.github.com/gfm/#example-155' => [
                'input' =>  "<div>" . "\n" .
                            "bar" . "\n" .
                            "</div>" . "\n" .
                            "*foo*",
                'render' => "<div>" . "\n" .
                            "bar" . "\n" .
                            "</div>" . "\n" .
                            "*foo*"
            ],
            'https://github.github.com/gfm/#example-156' => [
                'input' =>  "Foo" . "\n" .
                            "<a href=\"bar\">" . "\n" .
                            "baz",
                'render' => "<p>Foo" . "\n" .
                            "<a href=\"bar\">" . "\n" .
                            "baz</p>"
            ],
            'https://github.github.com/gfm/#example-157' => [
                'input' =>  "<div>" . "\n" .
                            "" . "\n" .
                            "*Emphasized* text." . "\n" .
                            "" . "\n" .
                            "</div>",
                'render' => "<div>" . "\n" .
                            "<p><em>Emphasized</em> text.</p>" . "\n" .
                            "</div>"
            ],
            'https://github.github.com/gfm/#example-158' => [
                'input' =>  "<div>" . "\n" .
                            "*Emphasized* text." . "\n" .
                            "</div>",
                'render' => "<div>" . "\n" .
                            "*Emphasized* text." . "\n" .
                            "</div>"
            ],
            'https://github.github.com/gfm/#example-159' => [
                'input' =>  "<table>" . "\n" .
                            "" . "\n" .
                            "<tr>" . "\n" .
                            "" . "\n" .
                            "<td>" . "\n" .
                            "Hi" . "\n" .
                            "</td>" . "\n" .
                            "" . "\n" .
                            "</tr>" . "\n" .
                            "" . "\n" .
                            "</table>",
                'render' => "<table>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>" . "\n" .
                            "Hi" . "\n" .
                            "</td>" . "\n" .
                            "</tr>" . "\n" .
                            "</table>"
            ],
            'https://github.github.com/gfm/#example-160' => [
                'input' =>  "<table>" . "\n" .
                            "" . "\n" .
                            "  <tr>" . "\n" .
                            "" . "\n" .
                            "    <td>" . "\n" .
                            "      Hi" . "\n" .
                            "    </td>" . "\n" .
                            "" . "\n" .
                            "  </tr>" . "\n" .
                            "" . "\n" .
                            "</table>",
                'render' => "<table>" . "\n" .
                            "  <tr>" . "\n" .
                            "<pre><code>&lt;td&gt;" . "\n" .
                            "  Hi" . "\n" .
                            "&lt;/td&gt;" . "\n" .
                            "</code></pre>" . "\n" .
                            "  </tr>" . "\n" .
                            "</table>"
            ],
        ];
    }

    public function dataLinkReferenceDefinitions(): array
    {
        return [
            'https://github.github.com/gfm/#example-161' => [
                'input' =>  "[foo]: /url \"title\"" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p><a href=\"/url\" title=\"title\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-162' => [
                'input' =>  "   [foo]: " . "\n" .
                            "      /url  " . "\n" .
                            "           'the title'  " . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p><a href=\"/url\" title=\"the title\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-163' => [
                'input' =>  "[Foo*bar\]]:my_(url) 'title (with parens)'" . "\n" .
                            "" . "\n" .
                            "[Foo*bar\]]",
                'render' => "<p><a href=\"my_(url)\" title=\"title (with parens)\">Foo*bar]</a></p>"
            ],
            'https://github.github.com/gfm/#example-164' => [
                'input' =>  "[Foo bar]:" . "\n" .
                            "<my url>" . "\n" .
                            "'title'" . "\n" .
                            "" . "\n" .
                            "[Foo bar]",
                'render' => "<p><a href=\"my%20url\" title=\"title\">Foo bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-165' => [
                'input' =>  "[foo]: /url '" . "\n" .
                            "title" . "\n" .
                            "line1" . "\n" .
                            "line2" . "\n" .
                            "'" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p><a href=\"/url\" title=\"" . "\n" .
                            "title" . "\n" .
                            "line1" . "\n" .
                            "line2" . "\n" .
                            "\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-166' => [
                'input' =>  "[foo]: /url 'title" . "\n" .
                            "" . "\n" .
                            "with blank line'" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p>[foo]: /url 'title</p>" . "\n" .
                            "<p>with blank line'</p>" . "\n" .
                            "<p>[foo]</p>"
            ],
            'https://github.github.com/gfm/#example-167' => [
                'input' =>  "[foo]:" . "\n" .
                            "/url" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p><a href=\"/url\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-168' => [
                'input' =>  "[foo]:" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p>[foo]:</p>" . "\n" .
                            "<p>[foo]</p>"
            ],
            'https://github.github.com/gfm/#example-169' => [
                'input' =>  "[foo]: <>" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p><a href=\"\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-170' => [
                'input' =>  "[foo]: <bar>(baz)" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p>[foo]: <bar>(baz)</p>" . "\n" .
                            "<p>[foo]</p>"
            ],
            'https://github.github.com/gfm/#example-171' => [
                'input' =>  "[foo]: /url\bar\*baz \"foo\"bar\baz\"" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<p><a href=\"/url%5Cbar*baz\" title=\"foo&quot;bar\baz\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-172' => [
                'input' =>  "[foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: url",
                'render' => "<p><a href=\"url\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-173' => [
                'input' =>  "[foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: first" . "\n" .
                            "[foo]: second",
                'render' => "<p><a href=\"first\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-174' => [
                'input' =>  "[FOO]: /url" . "\n" .
                            "" . "\n" .
                            "[Foo]",
                'render' => "<p><a href=\"/url\">Foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-175' => [
                'input' =>  "[ΑΓΩ]: /φου" . "\n" .
                            "" . "\n" .
                            "[αγω]",
                'render' => "<p><a href=\"/%CF%86%CE%BF%CF%85\">αγω</a></p>"
            ],
            'https://github.github.com/gfm/#example-176' => [
                'input' =>  "[foo]: /url",
                'render' => ""
            ],
            'https://github.github.com/gfm/#example-177' => [
                'input' =>  "[" . "\n" .
                            "foo" . "\n" .
                            "]: /url" . "\n" .
                            "bar",
                'render' => "<p>bar</p>"
            ],
            'https://github.github.com/gfm/#example-178' => [
                'input' =>  "[foo]: /url \"title\" ok",
                'render' => "<p>[foo]: /url &quot;title&quot; ok</p>"
            ],
            'https://github.github.com/gfm/#example-179' => [
                'input' =>  "[foo]: /url" . "\n" .
                            "\"title\" ok",
                'render' => "<p>&quot;title&quot; ok</p>"
            ],
            'https://github.github.com/gfm/#example-180' => [
                'input' =>  "    [foo]: /url \"title\"" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<pre><code>[foo]: /url &quot;title&quot;" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>[foo]</p>"
            ],
            'https://github.github.com/gfm/#example-181' => [
                'input' =>  "```" . "\n" .
                            "[foo]: /url" . "\n" .
                            "```" . "\n" .
                            "" . "\n" .
                            "[foo]",
                'render' => "<pre><code>[foo]: /url" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>[foo]</p>"
            ],
            'https://github.github.com/gfm/#example-182' => [
                'input' =>  "Foo" . "\n" .
                            "[bar]: /baz" . "\n" .
                            "" . "\n" .
                            "[bar]",
                'render' => "<p>Foo" . "\n" .
                            "[bar]: /baz</p>" . "\n" .
                            "<p>[bar]</p>"
            ],
            'https://github.github.com/gfm/#example-183' => [
                'input' =>  "# [Foo]" . "\n" .
                            "[foo]: /url" . "\n" .
                            "> bar",
                'render' => "<h1><a href=\"/url\">Foo</a></h1>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-184' => [
                'input' =>  "[foo]: /url" . "\n" .
                            "bar" . "\n" .
                            "===" . "\n" .
                            "[foo]",
                'render' => "<h1>bar</h1>" . "\n" .
                            "<p><a href=\"/url\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-185' => [
                'input' =>  "[foo]: /url" . "\n" .
                            "===" . "\n" .
                            "[foo]",
                'render' => "<p>===" . "\n" .
                            "<a href=\"/url\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-186' => [
                'input' =>  "[foo]: /foo-url \"foo\"" . "\n" .
                            "[bar]: /bar-url" . "\n" .
                            "  \"bar\"" . "\n" .
                            "[baz]: /baz-url" . "\n" .
                            "" . "\n" .
                            "[foo]," . "\n" .
                            "[bar]," . "\n" .
                            "[baz]",
                'render' => "<p><a href=\"/foo-url\" title=\"foo\">foo</a>," . "\n" .
                            "<a href=\"/bar-url\" title=\"bar\">bar</a>," . "\n" .
                            "<a href=\"/baz-url\">baz</a></p>"
            ],
            'https://github.github.com/gfm/#example-187' => [
                'input' =>  "[foo]" . "\n" .
                            "" . "\n" .
                            "> [foo]: /url",
                'render' => "<p><a href=\"/url\">foo</a></p>" . "\n" .
                            "<blockquote>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-188' => [
                'input' =>  "[foo]: /url",
                'render' => ""
            ],
        ];
    }

    public function dataParagraphs(): array
    {
        return [
            'https://github.github.com/gfm/#example-189' => [
                'input' =>  "aaa" . "\n" .
                            "" . "\n" .
                            "bbb",
                'render' => "<p>aaa</p>" . "\n" .
                            "<p>bbb</p>"
            ],
            'https://github.github.com/gfm/#example-190' => [
                'input' =>  "aaa" . "\n" .
                            "bbb" . "\n" .
                            "" . "\n" .
                            "ccc" . "\n" .
                            "ddd",
                'render' => "<p>aaa" . "\n" .
                            "bbb</p>" . "\n" .
                            "<p>ccc" . "\n" .
                            "ddd</p>"
            ],
            'https://github.github.com/gfm/#example-191' => [
                'input' =>  "aaa" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "bbb",
                'render' => "<p>aaa</p>" . "\n" .
                            "<p>bbb</p>"
            ],
            'https://github.github.com/gfm/#example-192' => [
                'input' =>  "  aaa" . "\n" .
                            " bbb",
                'render' => "<p>aaa" . "\n" .
                            "bbb</p>"
            ],
            'https://github.github.com/gfm/#example-193' => [
                'input' =>  "aaa" . "\n" .
                            "             bbb" . "\n" .
                            "                                       ccc",
                'render' => "<p>aaa" . "\n" .
                            "bbb" . "\n" .
                            "ccc</p>"
            ],
            'https://github.github.com/gfm/#example-194' => [
                'input' =>  "   aaa" . "\n" .
                            "bbb",
                'render' => "<p>aaa" . "\n" .
                            "bbb</p>"
            ],
            'https://github.github.com/gfm/#example-195' => [
                'input' =>  "    aaa" . "\n" .
                            "bbb",
                'render' => "<pre><code>aaa" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>bbb</p>"
            ],
            'https://github.github.com/gfm/#example-196' => [
                'input' =>  "aaa     " . "\n" .
                            "bbb     ",
                'render' => "<p>aaa<br />" . "\n" .
                            "bbb</p>"
            ],
        ];
    }

    public function dataBlankLines(): array
    {
        return [
            'https://github.github.com/gfm/#example-197' => [
                'input' =>  "  " . "\n" .
                            "" . "\n" .
                            "aaa" . "\n" .
                            "  " . "\n" .
                            "" . "\n" .
                            "# aaa" . "\n" .
                            "" . "\n" .
                            "  ",
                'render' => "<p>aaa</p>" . "\n" .
                            "<h1>aaa</h1>"
            ],
        ];
    }

    public function dataTables(): array
    {
        return [
            'https://github.github.com/gfm/#example-198' => [
                'input' =>  "| foo | bar |" . "\n" .
                            "| --- | --- |" . "\n" .
                            "| baz | bim |",
                'render' => "<table>" . "\n" .
                            "<thead>" . "\n" .
                            "<tr>" . "\n" .
                            "<th>foo</th>" . "\n" .
                            "<th>bar</th>" . "\n" .
                            "</tr>" . "\n" .
                            "</thead>" . "\n" .
                            "<tbody>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>baz</td>" . "\n" .
                            "<td>bim</td>" . "\n" .
                            "</tr>" . "\n" .
                            "</tbody>" . "\n" .
                            "</table>"
            ],
            'https://github.github.com/gfm/#example-199' => [
                'input' =>  "| abc | defghi |" . "\n" .
                            ":-: | -----------:" . "\n" .
                            "bar | baz",
                'render' => "<table>" . "\n" .
                            "<thead>" . "\n" .
                            "<tr>" . "\n" .
                            "<th align=\"center\">abc</th>" . "\n" .
                            "<th align=\"right\">defghi</th>" . "\n" .
                            "</tr>" . "\n" .
                            "</thead>" . "\n" .
                            "<tbody>" . "\n" .
                            "<tr>" . "\n" .
                            "<td align=\"center\">bar</td>" . "\n" .
                            "<td align=\"right\">baz</td>" . "\n" .
                            "</tr>" . "\n" .
                            "</tbody>" . "\n" .
                            "</table>"
            ],
            'https://github.github.com/gfm/#example-200' => [
                'input' =>  "| f\|oo  |" . "\n" .
                            "| ------ |" . "\n" .
                            "| b `\|` az |" . "\n" .
                            "| b **\|** im |",
                'render' => "<table>" . "\n" .
                            "<thead>" . "\n" .
                            "<tr>" . "\n" .
                            "<th>f|oo</th>" . "\n" .
                            "</tr>" . "\n" .
                            "</thead>" . "\n" .
                            "<tbody>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>b <code>|</code> az</td>" . "\n" .
                            "</tr>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>b <strong>|</strong> im</td>" . "\n" .
                            "</tr>" . "\n" .
                            "</tbody>" . "\n" .
                            "</table>"
            ],
            'https://github.github.com/gfm/#example-201' => [
                'input' =>  "| abc | def |" . "\n" .
                            "| --- | --- |" . "\n" .
                            "| bar | baz |" . "\n" .
                            "> bar",
                'render' => "<table>" . "\n" .
                            "<thead>" . "\n" .
                            "<tr>" . "\n" .
                            "<th>abc</th>" . "\n" .
                            "<th>def</th>" . "\n" .
                            "</tr>" . "\n" .
                            "</thead>" . "\n" .
                            "<tbody>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>bar</td>" . "\n" .
                            "<td>baz</td>" . "\n" .
                            "</tr>" . "\n" .
                            "</tbody>" . "\n" .
                            "</table>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-202' => [
                'input' =>  "| abc | def |" . "\n" .
                            "| --- | --- |" . "\n" .
                            "| bar | baz |" . "\n" .
                            "bar" . "\n" .
                            "" . "\n" .
                            "bar",
                'render' => "<table>" . "\n" .
                            "<thead>" . "\n" .
                            "<tr>" . "\n" .
                            "<th>abc</th>" . "\n" .
                            "<th>def</th>" . "\n" .
                            "</tr>" . "\n" .
                            "</thead>" . "\n" .
                            "<tbody>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>bar</td>" . "\n" .
                            "<td>baz</td>" . "\n" .
                            "</tr>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>bar</td>" . "\n" .
                            "<td></td>" . "\n" .
                            "</tr>" . "\n" .
                            "</tbody>" . "\n" .
                            "</table>" . "\n" .
                            "<p>bar</p>"
            ],
            'https://github.github.com/gfm/#example-203' => [
                'input' =>  "| abc | def |" . "\n" .
                            "| --- |" . "\n" .
                            "| bar |",
                'render' => "<p>| abc | def |" . "\n" .
                            "| --- |" . "\n" .
                            "| bar |</p>"
            ],
            'https://github.github.com/gfm/#example-204' => [
                'input' =>  "| abc | def |" . "\n" .
                            "| --- | --- |" . "\n" .
                            "| bar |" . "\n" .
                            "| bar | baz | boo |",
                'render' => "<table>" . "\n" .
                            "<thead>" . "\n" .
                            "<tr>" . "\n" .
                            "<th>abc</th>" . "\n" .
                            "<th>def</th>" . "\n" .
                            "</tr>" . "\n" .
                            "</thead>" . "\n" .
                            "<tbody>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>bar</td>" . "\n" .
                            "<td></td>" . "\n" .
                            "</tr>" . "\n" .
                            "<tr>" . "\n" .
                            "<td>bar</td>" . "\n" .
                            "<td>baz</td>" . "\n" .
                            "</tr>" . "\n" .
                            "</tbody>" . "\n" .
                            "</table>"
            ],
            'https://github.github.com/gfm/#example-205' => [
                'input' =>  "| abc | def |" . "\n" .
                            "| --- | --- |",
                'render' => "<table>" . "\n" .
                            "<thead>" . "\n" .
                            "<tr>" . "\n" .
                            "<th>abc</th>" . "\n" .
                            "<th>def</th>" . "\n" .
                            "</tr>" . "\n" .
                            "</thead>" . "\n" .
                            "</table>"
            ],
        ];
    }

    public function dataBlockQuotes(): array
    {
        return [
            'https://github.github.com/gfm/#example-206' => [
                'input' =>  "> # Foo" . "\n" .
                            "> bar" . "\n" .
                            "> baz",
                'render' => "<blockquote>" . "\n" .
                            "<h1>Foo</h1>" . "\n" .
                            "<p>bar" . "\n" .
                            "baz</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-207' => [
                'input' =>  "># Foo" . "\n" .
                            ">bar" . "\n" .
                            "> baz",
                'render' => "<blockquote>" . "\n" .
                            "<h1>Foo</h1>" . "\n" .
                            "<p>bar" . "\n" .
                            "baz</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-208' => [
                'input' =>  "   > # Foo" . "\n" .
                            "   > bar" . "\n" .
                            " > baz",
                'render' => "<blockquote>" . "\n" .
                            "<h1>Foo</h1>" . "\n" .
                            "<p>bar" . "\n" .
                            "baz</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-209' => [
                'input' =>  "    > # Foo" . "\n" .
                            "    > bar" . "\n" .
                            "    > baz",
                'render' => "<pre><code>&gt; # Foo" . "\n" .
                            "&gt; bar" . "\n" .
                            "&gt; baz" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-210' => [
                'input' =>  "> # Foo" . "\n" .
                            "> bar" . "\n" .
                            "baz",
                'render' => "<blockquote>" . "\n" .
                            "<h1>Foo</h1>" . "\n" .
                            "<p>bar" . "\n" .
                            "baz</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-211' => [
                'input' =>  "> bar" . "\n" .
                            "baz" . "\n" .
                            "> foo",
                'render' => "<blockquote>" . "\n" .
                            "<p>bar" . "\n" .
                            "baz" . "\n" .
                            "foo</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-212' => [
                'input' =>  "> foo" . "\n" .
                            "---",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<hr />"
            ],
            'https://github.github.com/gfm/#example-213' => [
                'input' =>  "> - foo" . "\n" .
                            "- bar",
                'render' => "<blockquote>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-214' => [
                'input' =>  ">     foo" . "\n" .
                            "    bar",
                'render' => "<blockquote>" . "\n" .
                            "<pre><code>foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-215' => [
                'input' =>  "> ```" . "\n" .
                            "foo" . "\n" .
                            "```",
                'render' => "<blockquote>" . "\n" .
                            "<pre><code></code></pre>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<pre><code></code></pre>"
            ],
            'https://github.github.com/gfm/#example-216' => [
                'input' =>  "> foo" . "\n" .
                            "    - bar",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo" . "\n" .
                            "- bar</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-217' => [
                'input' =>  ">",
                'render' => "<blockquote>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-218' => [
                'input' =>  ">" . "\n" .
                            ">  " . "\n" .
                            "> ",
                'render' => "<blockquote>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-219' => [
                'input' =>  ">" . "\n" .
                            "> foo" . "\n" .
                            ">  ",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-220' => [
                'input' =>  "> foo" . "\n" .
                            "" . "\n" .
                            "> bar",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-221' => [
                'input' =>  "> foo" . "\n" .
                            "> bar",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo" . "\n" .
                            "bar</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-222' => [
                'input' =>  "> foo" . "\n" .
                            ">" . "\n" .
                            "> bar",
                'render' => "<blockquote>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-223' => [
                'input' =>  "foo" . "\n" .
                            "> bar",
                'render' => "<p>foo</p>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-224' => [
                'input' =>  "> aaa" . "\n" .
                            "***" . "\n" .
                            "> bbb",
                'render' => "<blockquote>" . "\n" .
                            "<p>aaa</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<hr />" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>bbb</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-225' => [
                'input' =>  "> bar" . "\n" .
                            "baz",
                'render' => "<blockquote>" . "\n" .
                            "<p>bar" . "\n" .
                            "baz</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-226' => [
                'input' =>  "> bar" . "\n" .
                            "" . "\n" .
                            "baz",
                'render' => "<blockquote>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<p>baz</p>"
            ],
            'https://github.github.com/gfm/#example-227' => [
                'input' =>  "> bar" . "\n" .
                            ">" . "\n" .
                            "baz",
                'render' => "<blockquote>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<p>baz</p>"
            ],
            'https://github.github.com/gfm/#example-228' => [
                'input' =>  "> > > foo" . "\n" .
                            "bar",
                'render' => "<blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>foo" . "\n" .
                            "bar</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-229' => [
                'input' =>  ">>> foo" . "\n" .
                            "> bar" . "\n" .
                            ">>baz",
                'render' => "<blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>foo" . "\n" .
                            "bar" . "\n" .
                            "baz</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-230' => [
                'input' =>  ">     code" . "\n" .
                            "" . "\n" .
                            ">    not code",
                'render' => "<blockquote>" . "\n" .
                            "<pre><code>code" . "\n" .
                            "</code></pre>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>not code</p>" . "\n" .
                            "</blockquote>"
            ],
        ];
    }

    public function dataListItems(): array
    {
        return [
            'https://github.github.com/gfm/#example-231' => [
                'input' =>  "A paragraph" . "\n" .
                            "with two lines." . "\n" .
                            "" . "\n" .
                            "    indented code" . "\n" .
                            "" . "\n" .
                            "> A block quote.",
                'render' => "<p>A paragraph" . "\n" .
                            "with two lines.</p>" . "\n" .
                            "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>A block quote.</p>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-232' => [
                'input' =>  "1.  A paragraph" . "\n" .
                            "    with two lines." . "\n" .
                            "" . "\n" .
                            "        indented code" . "\n" .
                            "" . "\n" .
                            "    > A block quote.",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>A paragraph" . "\n" .
                            "with two lines.</p>" . "\n" .
                            "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>A block quote.</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-233' => [
                'input' =>  "- one" . "\n" .
                            "" . "\n" .
                            " two",
                'render' => "<ul>" . "\n" .
                            "<li>one</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<p>two</p>"
            ],
            'https://github.github.com/gfm/#example-234' => [
                'input' =>  "- one" . "\n" .
                            "" . "\n" .
                            "  two",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>one</p>" . "\n" .
                            "<p>two</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-235' => [
                'input' =>  " -    one" . "\n" .
                            "" . "\n" .
                            "     two",
                'render' => "<ul>" . "\n" .
                            "<li>one</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<pre><code> two" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-236' => [
                'input' =>  " -    one" . "\n" .
                            "" . "\n" .
                            "      two",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>one</p>" . "\n" .
                            "<p>two</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-237' => [
                'input' =>  "   > > 1.  one" . "\n" .
                            ">>" . "\n" .
                            ">>     two",
                'render' => "<blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>one</p>" . "\n" .
                            "<p>two</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-238' => [
                'input' =>  ">>- one" . "\n" .
                            ">>" . "\n" .
                            "  >  > two",
                'render' => "<blockquote>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>one</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<p>two</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-239' => [
                'input' =>  "-one" . "\n" .
                            "" . "\n" .
                            "2.two",
                'render' => "<p>-one</p>" . "\n" .
                            "<p>2.two</p>"
            ],
            'https://github.github.com/gfm/#example-240' => [
                'input' =>  "- foo" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "  bar",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-241' => [
                'input' =>  "1.  foo" . "\n" .
                            "" . "\n" .
                            "    ```" . "\n" .
                            "    bar" . "\n" .
                            "    ```" . "\n" .
                            "" . "\n" .
                            "    baz" . "\n" .
                            "" . "\n" .
                            "    > bam",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>baz</p>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>bam</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-242' => [
                'input' =>  "- Foo" . "\n" .
                            "" . "\n" .
                            "      bar" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "      baz",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>Foo</p>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "baz" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-243' => [
                'input' =>  "123456789. ok",
                'render' => "<ol start=\"123456789\">" . "\n" .
                            "<li>ok</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-244' => [
                'input' =>  "1234567890. not ok",
                'render' => "<p>1234567890. not ok</p>"
            ],
            'https://github.github.com/gfm/#example-245' => [
                'input' =>  "0. ok",
                'render' => "<ol start=\"0\">" . "\n" .
                            "<li>ok</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-246' => [
                'input' =>  "003. ok",
                'render' => "<ol start=\"3\">" . "\n" .
                            "<li>ok</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-247' => [
                'input' =>  "-1. not ok",
                'render' => "<p>-1. not ok</p>"
            ],
            'https://github.github.com/gfm/#example-248' => [
                'input' =>  "- foo" . "\n" .
                            "" . "\n" .
                            "      bar",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-249' => [
                'input' =>  "  10.  foo" . "\n" .
                            "" . "\n" .
                            "           bar",
                'render' => "<ol start=\"10\">" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-250' => [
                'input' =>  "    indented code" . "\n" .
                            "" . "\n" .
                            "paragraph" . "\n" .
                            "" . "\n" .
                            "    more code",
                'render' => "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>paragraph</p>" . "\n" .
                            "<pre><code>more code" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-251' => [
                'input' =>  "1.     indented code" . "\n" .
                            "" . "\n" .
                            "   paragraph" . "\n" .
                            "" . "\n" .
                            "       more code",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>paragraph</p>" . "\n" .
                            "<pre><code>more code" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-252' => [
                'input' =>  "1.      indented code" . "\n" .
                            "" . "\n" .
                            "   paragraph" . "\n" .
                            "" . "\n" .
                            "       more code",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code> indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>paragraph</p>" . "\n" .
                            "<pre><code>more code" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-253' => [
                'input' =>  "   foo" . "\n" .
                            "" . "\n" .
                            "bar",
                'render' => "<p>foo</p>" . "\n" .
                            "<p>bar</p>"
            ],
            'https://github.github.com/gfm/#example-254' => [
                'input' =>  "-    foo" . "\n" .
                            "" . "\n" .
                            "  bar",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<p>bar</p>"
            ],
            'https://github.github.com/gfm/#example-255' => [
                'input' =>  "-  foo" . "\n" .
                            "" . "\n" .
                            "   bar",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-256' => [
                'input' =>  "-" . "\n" .
                            "  foo" . "\n" .
                            "-" . "\n" .
                            "  ```" . "\n" .
                            "  bar" . "\n" .
                            "  ```" . "\n" .
                            "-" . "\n" .
                            "      baz",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code>bar" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code>baz" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-257' => [
                'input' =>  "-   " . "\n" .
                            "  foo",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-258' => [
                'input' =>  "-" . "\n" .
                            "" . "\n" .
                            "  foo",
                'render' => "<ul>" . "\n" .
                            "<li></li>" . "\n" .
                            "</ul>" . "\n" .
                            "<p>foo</p>"
            ],
            'https://github.github.com/gfm/#example-259' => [
                'input' =>  "- foo" . "\n" .
                            "-" . "\n" .
                            "- bar",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li></li>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-260' => [
                'input' =>  "- foo" . "\n" .
                            "-   " . "\n" .
                            "- bar",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li></li>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-261' => [
                'input' =>  "1. foo" . "\n" .
                            "2." . "\n" .
                            "3. bar",
                'render' => "<ol>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li></li>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-262' => [
                'input' =>  "*",
                'render' => "<ul>" . "\n" .
                            "<li></li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-263' => [
                'input' =>  "foo" . "\n" .
                            "*" . "\n" .
                            "" . "\n" .
                            "foo" . "\n" .
                            "1.",
                'render' => "<p>foo" . "\n" .
                            "*</p>" . "\n" .
                            "<p>foo" . "\n" .
                            "1.</p>"
            ],
            'https://github.github.com/gfm/#example-264' => [
                'input' =>  " 1.  A paragraph" . "\n" .
                            "     with two lines." . "\n" .
                            "" . "\n" .
                            "         indented code" . "\n" .
                            "" . "\n" .
                            "     > A block quote.",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>A paragraph" . "\n" .
                            "with two lines.</p>" . "\n" .
                            "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>A block quote.</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-265' => [
                'input' =>  "  1.  A paragraph" . "\n" .
                            "      with two lines." . "\n" .
                            "" . "\n" .
                            "          indented code" . "\n" .
                            "" . "\n" .
                            "      > A block quote.",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>A paragraph" . "\n" .
                            "with two lines.</p>" . "\n" .
                            "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>A block quote.</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-266' => [
                'input' =>  "   1.  A paragraph" . "\n" .
                            "       with two lines." . "\n" .
                            "" . "\n" .
                            "           indented code" . "\n" .
                            "" . "\n" .
                            "       > A block quote.",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>A paragraph" . "\n" .
                            "with two lines.</p>" . "\n" .
                            "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>A block quote.</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-267' => [
                'input' =>  "    1.  A paragraph" . "\n" .
                            "        with two lines." . "\n" .
                            "" . "\n" .
                            "            indented code" . "\n" .
                            "" . "\n" .
                            "        > A block quote.",
                'render' => "<pre><code>1.  A paragraph" . "\n" .
                            "    with two lines." . "\n" .
                            "" . "\n" .
                            "        indented code" . "\n" .
                            "" . "\n" .
                            "    &gt; A block quote." . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-268' => [
                'input' =>  "  1.  A paragraph" . "\n" .
                            "with two lines." . "\n" .
                            "" . "\n" .
                            "          indented code" . "\n" .
                            "" . "\n" .
                            "      > A block quote.",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>A paragraph" . "\n" .
                            "with two lines.</p>" . "\n" .
                            "<pre><code>indented code" . "\n" .
                            "</code></pre>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>A block quote.</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-269' => [
                'input' =>  "  1.  A paragraph" . "\n" .
                            "    with two lines.",
                'render' => "<ol>" . "\n" .
                            "<li>A paragraph" . "\n" .
                            "with two lines.</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-270' => [
                'input' =>  "> 1. > Blockquote" . "\n" .
                            "continued here.",
                'render' => "<blockquote>" . "\n" .
                            "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>Blockquote" . "\n" .
                            "continued here.</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-271' => [
                'input' =>  "> 1. > Blockquote" . "\n" .
                            "> continued here.",
                'render' => "<blockquote>" . "\n" .
                            "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>Blockquote" . "\n" .
                            "continued here.</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>" . "\n" .
                            "</blockquote>"
            ],
            'https://github.github.com/gfm/#example-272' => [
                'input' =>  "- foo" . "\n" .
                            "  - bar" . "\n" .
                            "    - baz" . "\n" .
                            "      - boo",
                'render' => "<ul>" . "\n" .
                            "<li>foo" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar" . "\n" .
                            "<ul>" . "\n" .
                            "<li>baz" . "\n" .
                            "<ul>" . "\n" .
                            "<li>boo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-273' => [
                'input' =>  "- foo" . "\n" .
                            " - bar" . "\n" .
                            "  - baz" . "\n" .
                            "   - boo",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "<li>baz</li>" . "\n" .
                            "<li>boo</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-274' => [
                'input' =>  "10) foo" . "\n" .
                            "    - bar",
                'render' => "<ol start=\"10\">" . "\n" .
                            "<li>foo" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-275' => [
                'input' =>  "10) foo" . "\n" .
                            "   - bar",
                'render' => "<ol start=\"10\">" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ol>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-276' => [
                'input' =>  "- - foo",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-277' => [
                'input' =>  "1. - 2. foo",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<ol start=\"2\">" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ol>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-278' => [
                'input' =>  "- # Foo" . "\n" .
                            "- Bar" . "\n" .
                            "  ---" . "\n" .
                            "  baz",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<h1>Foo</h1>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<h2>Bar</h2>" . "\n" .
                            "baz</li>" . "\n" .
                            "</ul>"
            ],
        ];
    }

    public function dataTaskListItems(): array
    {
        return [
            'https://github.github.com/gfm/#example-279' => [
                'input' =>  "- [ ] foo" . "\n" .
                            "- [x] bar",
                'render' => "<ul>" . "\n" .
                            "<li><input disabled=\"\" type=\"checkbox\"> foo</li>" . "\n" .
                            "<li><input checked=\"\" disabled=\"\" type=\"checkbox\"> bar</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-280' => [
                'input' =>  "- [x] foo" . "\n" .
                            "  - [ ] bar" . "\n" .
                            "  - [x] baz" . "\n" .
                            "- [ ] bim",
                'render' => "<ul>" . "\n" .
                            "<li><input checked=\"\" disabled=\"\" type=\"checkbox\"> foo" . "\n" .
                            "<ul>" . "\n" .
                            "<li><input disabled=\"\" type=\"checkbox\"> bar</li>" . "\n" .
                            "<li><input checked=\"\" disabled=\"\" type=\"checkbox\"> baz</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "<li><input disabled=\"\" type=\"checkbox\"> bim</li>" . "\n" .
                            "</ul>"
            ],
        ];
    }

    public function dataList(): array
    {
        return [
            'https://github.github.com/gfm/#example-281' => [
                'input' =>  "- foo" . "\n" .
                            "- bar" . "\n" .
                            "+ baz",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>baz</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-282' => [
                'input' =>  "1. foo" . "\n" .
                            "2. bar" . "\n" .
                            "3) baz",
                'render' => "<ol>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ol>" . "\n" .
                            "<ol start=\"3\">" . "\n" .
                            "<li>baz</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-283' => [
                'input' =>  "Foo" . "\n" .
                            "- bar" . "\n" .
                            "- baz",
                'render' => "<p>Foo</p>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "<li>baz</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-284' => [
                'input' =>  "The number of windows in my house is" . "\n" .
                            "14.  The number of doors is 6.",
                'render' => "<p>The number of windows in my house is" . "\n" .
                            "14.  The number of doors is 6.</p>"
            ],
            'https://github.github.com/gfm/#example-285' => [
                'input' =>  "The number of windows in my house is" . "\n" .
                            "1.  The number of doors is 6.",
                'render' => "<p>The number of windows in my house is</p>" . "\n" .
                            "<ol>" . "\n" .
                            "<li>The number of doors is 6.</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-286' => [
                'input' =>  "- foo" . "\n" .
                            "" . "\n" .
                            "- bar" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "- baz",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>baz</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-287' => [
                'input' =>  "- foo" . "\n" .
                            "  - bar" . "\n" .
                            "    - baz" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "      bim",
                'render' => "<ul>" . "\n" .
                            "<li>foo" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar" . "\n" .
                            "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>baz</p>" . "\n" .
                            "<p>bim</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-288' => [
                'input' =>  "- foo" . "\n" .
                            "- bar" . "\n" .
                            "" . "\n" .
                            "<!-- -->" . "\n" .
                            "" . "\n" .
                            "- baz" . "\n" .
                            "- bim",
                'render' => "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<!-- -->" . "\n" .
                            "<ul>" . "\n" .
                            "<li>baz</li>" . "\n" .
                            "<li>bim</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-289' => [
                'input' =>  "-   foo" . "\n" .
                            "" . "\n" .
                            "    notcode" . "\n" .
                            "" . "\n" .
                            "-   foo" . "\n" .
                            "" . "\n" .
                            "<!-- -->" . "\n" .
                            "" . "\n" .
                            "    code",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<p>notcode</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<!-- -->" . "\n" .
                            "<pre><code>code" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-290' => [
                'input' =>  "- a" . "\n" .
                            " - b" . "\n" .
                            "  - c" . "\n" .
                            "   - d" . "\n" .
                            "  - e" . "\n" .
                            " - f" . "\n" .
                            "- g",
                'render' => "<ul>" . "\n" .
                            "<li>a</li>" . "\n" .
                            "<li>b</li>" . "\n" .
                            "<li>c</li>" . "\n" .
                            "<li>d</li>" . "\n" .
                            "<li>e</li>" . "\n" .
                            "<li>f</li>" . "\n" .
                            "<li>g</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-291' => [
                'input' =>  "1. a" . "\n" .
                            "" . "\n" .
                            "  2. b" . "\n" .
                            "" . "\n" .
                            "   3. c",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>a</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>c</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-292' => [
                'input' =>  "- a" . "\n" .
                            " - b" . "\n" .
                            "  - c" . "\n" .
                            "   - d" . "\n" .
                            "    - e",
                'render' => "<ul>" . "\n" .
                            "<li>a</li>" . "\n" .
                            "<li>b</li>" . "\n" .
                            "<li>c</li>" . "\n" .
                            "<li>d" . "\n" .
                            "- e</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-293' => [
                'input' =>  "1. a" . "\n" .
                            "" . "\n" .
                            "  2. b" . "\n" .
                            "" . "\n" .
                            "    3. c",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<p>a</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>" . "\n" .
                            "<pre><code>3. c" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-294' => [
                'input' =>  "- a" . "\n" .
                            "- b" . "\n" .
                            "" . "\n" .
                            "- c",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>a</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>c</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-295' => [
                'input' =>  "* a" . "\n" .
                            "*" . "\n" .
                            "" . "\n" .
                            "* c",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>a</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li></li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>c</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-296' => [
                'input' =>  "- a" . "\n" .
                            "- b" . "\n" .
                            "" . "\n" .
                            "  c" . "\n" .
                            "- d",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>a</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "<p>c</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>d</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-297' => [
                'input' =>  "- a" . "\n" .
                            "- b" . "\n" .
                            "" . "\n" .
                            "  [ref]: /url" . "\n" .
                            "- d",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>a</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>d</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-298' => [
                'input' =>  "- a" . "\n" .
                            "- ```" . "\n" .
                            "  b" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "  ```" . "\n" .
                            "- c",
                'render' => "<ul>" . "\n" .
                            "<li>a</li>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code>b" . "\n" .
                            "" . "\n" .
                            "" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "<li>c</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-299' => [
                'input' =>  "- a" . "\n" .
                            "  - b" . "\n" .
                            "" . "\n" .
                            "    c" . "\n" .
                            "- d",
                'render' => "<ul>" . "\n" .
                            "<li>a" . "\n" .
                            "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "<p>c</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "<li>d</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-300' => [
                'input' =>  "* a" . "\n" .
                            "  > b" . "\n" .
                            "  >" . "\n" .
                            "* c",
                'render' => "<ul>" . "\n" .
                            "<li>a" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "</li>" . "\n" .
                            "<li>c</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-301' => [
                'input' =>  "- a" . "\n" .
                            "  > b" . "\n" .
                            "  ```" . "\n" .
                            "  c" . "\n" .
                            "  ```" . "\n" .
                            "- d",
                'render' => "<ul>" . "\n" .
                            "<li>a" . "\n" .
                            "<blockquote>" . "\n" .
                            "<p>b</p>" . "\n" .
                            "</blockquote>" . "\n" .
                            "<pre><code>c" . "\n" .
                            "</code></pre>" . "\n" .
                            "</li>" . "\n" .
                            "<li>d</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-302' => [
                'input' =>  "- a",
                'render' => "<ul>" . "\n" .
                            "<li>a</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-303' => [
                'input' =>  "- a" . "\n" .
                            "  - b",
                'render' => "<ul>" . "\n" .
                            "<li>a" . "\n" .
                            "<ul>" . "\n" .
                            "<li>b</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-304' => [
                'input' =>  "1. ```" . "\n" .
                            "   foo" . "\n" .
                            "   ```" . "\n" .
                            "" . "\n" .
                            "   bar",
                'render' => "<ol>" . "\n" .
                            "<li>" . "\n" .
                            "<pre><code>foo" . "\n" .
                            "</code></pre>" . "\n" .
                            "<p>bar</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ol>"
            ],
            'https://github.github.com/gfm/#example-305' => [
                'input' =>  "* foo" . "\n" .
                            "  * bar" . "\n" .
                            "" . "\n" .
                            "  baz",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>foo</p>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>bar</li>" . "\n" .
                            "</ul>" . "\n" .
                            "<p>baz</p>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-306' => [
                'input' =>  "- a" . "\n" .
                            "  - b" . "\n" .
                            "  - c" . "\n" .
                            "" . "\n" .
                            "- d" . "\n" .
                            "  - e" . "\n" .
                            "  - f",
                'render' => "<ul>" . "\n" .
                            "<li>" . "\n" .
                            "<p>a</p>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>b</li>" . "\n" .
                            "<li>c</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "<li>" . "\n" .
                            "<p>d</p>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>e</li>" . "\n" .
                            "<li>f</li>" . "\n" .
                            "</ul>" . "\n" .
                            "</li>" . "\n" .
                            "</ul>"
            ],
        ];
    }

    public function dataBackslashEscapes(): array
    {
        return [
            'https://github.github.com/gfm/#example-307' => [
                'input' =>  "`hi`lo`",
                'render' => "<p><code>hi</code>lo`</p>"
            ],
            'https://github.github.com/gfm/#example-308' => [
                'input' =>  "\!\"\#\$\%\&\'\(\)\*\+\,\-\.\/\:\;\<\=\>\?\@\[\\\]\^\_\`\{\|\}\~",
                'render' => "<p>!&quot;#$%&amp;'()*+,-./:;&lt;=&gt;?@[\]^_`{|}~</p>"
            ],
            'https://github.github.com/gfm/#example-309' => [
                'input' =>  "\\t\A\a\ \3\φ\«",
                'render' => "<p>\\t\A\a\ \3\φ\«</p>"
            ],
            'https://github.github.com/gfm/#example-310' => [
                'input' =>  "\*not emphasized*" . "\n" .
                            "\<br/> not a tag" . "\n" .
                            "\[not a link](/foo)" . "\n" .
                            "\`not code`" . "\n" .
                            "1\. not a list" . "\n" .
                            "\* not a list" . "\n" .
                            "\# not a heading" . "\n" .
                            "\[foo]: /url \"not a reference\"" . "\n" .
                            "\&ouml; not a character entity",
                'render' => "<p>*not emphasized*" . "\n" .
                            "&lt;br/&gt; not a tag" . "\n" .
                            "[not a link](/foo)" . "\n" .
                            "`not code`" . "\n" .
                            "1. not a list" . "\n" .
                            "* not a list" . "\n" .
                            "# not a heading" . "\n" .
                            "[foo]: /url &quot;not a reference&quot;" . "\n" .
                            "&amp;ouml; not a character entity</p>"
            ],
            'https://github.github.com/gfm/#example-311' => [
                'input' =>  "\\*emphasis*",
                'render' => "<p>\<em>emphasis</em></p>"
            ],
            'https://github.github.com/gfm/#example-312' => [
                'input' =>  "foo\\" . "\n" .
                            "bar",
                'render' => "<p>foo<br />" . "\n" .
                            "bar</p>"
            ],
            'https://github.github.com/gfm/#example-313' => [
                'input' =>  "`` \[\` ``",
                'render' => "<p><code>\[\`</code></p>"
            ],
            'https://github.github.com/gfm/#example-314' => [
                'input' =>  "    \[\]",
                'render' => "<pre><code>\[\]" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-315' => [
                'input' =>  "~~~" . "\n" .
                            "\[\]" . "\n" .
                            "~~~",
                'render' => "<pre><code>\[\]" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-316' => [
                'input' =>  "<http://example.com?find=\*>",
                'render' => "<p><a href=\"http://example.com?find=%5C*\">http://example.com?find=\*</a></p>"
            ],
            'https://github.github.com/gfm/#example-317' => [
                'input' =>  "<a href=\"/bar\/)\">",
                'render' => "<a href=\"/bar\/)\">"
            ],
            'https://github.github.com/gfm/#example-318' => [
                'input' =>  "[foo](/bar\* \"ti\*tle\")",
                'render' => "<p><a href=\"/bar*\" title=\"ti*tle\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-319' => [
                'input' =>  "[foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /bar\* \"ti\*tle\"",
                'render' => "<p><a href=\"/bar*\" title=\"ti*tle\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-320' => [
                'input' =>  "``` foo\+bar" . "\n" .
                            "foo" . "\n" .
                            "```",
                'render' => "<pre><code class=\"language-foo+bar\">foo" . "\n" .
                            "</code></pre>"
            ],
        ];
    }

    public function dataEntityAndNumericCharacterReferences(): array
    {
        return [
            'https://github.github.com/gfm/#example-321' => [
                'input' =>  "&nbsp; &amp; &copy; &AElig; &Dcaron;" . "\n" .
                            "&frac34; &HilbertSpace; &DifferentialD;" . "\n" .
                            "&ClockwiseContourIntegral; &ngE;",
                'render' => "<p>  &amp; © Æ Ď" . "\n" .
                            "¾ ℋ ⅆ" . "\n" .
                            "∲ ≧̸</p>"
            ],
            'https://github.github.com/gfm/#example-322' => [
                'input' =>  "&#35; &#1234; &#992; &#0;",
                'render' => "<p># Ӓ Ϡ �</p>"
            ],
            'https://github.github.com/gfm/#example-323' => [
                'input' =>  "&#X22; &#XD06; &#xcab;",
                'render' => "<p>&quot; ആ ಫ</p>"
            ],
            'https://github.github.com/gfm/#example-324' => [
                'input' =>  "&nbsp &x; &#; &#x;" . "\n" .
                            "&#87654321;" . "\n" .
                            "&#abcdef0;" . "\n" .
                            "&ThisIsNotDefined; &hi?;",
                'render' => "<p>&amp;nbsp &amp;x; &amp;#; &amp;#x;" . "\n" .
                            "&amp;#87654321;" . "\n" .
                            "&amp;#abcdef0;" . "\n" .
                            "&amp;ThisIsNotDefined; &amp;hi?;</p>"
            ],
            'https://github.github.com/gfm/#example-325' => [
                'input' =>  "&copy",
                'render' => "<p>&amp;copy</p>"
            ],
            'https://github.github.com/gfm/#example-326' => [
                'input' =>  "&MadeUpEntity;",
                'render' => "<p>&amp;MadeUpEntity;</p>"
            ],
            'https://github.github.com/gfm/#example-327' => [
                'input' =>  "<a href=\"&ouml;&ouml;.html\">",
                'render' => "<a href=\"&ouml;&ouml;.html\">"
            ],
            'https://github.github.com/gfm/#example-328' => [
                'input' =>  "[foo](/f&ouml;&ouml; \"f&ouml;&ouml;\")",
                'render' => "<p><a href=\"/f%C3%B6%C3%B6\" title=\"föö\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-329' => [
                'input' =>  "[foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /f&ouml;&ouml; \"f&ouml;&ouml;\"",
                'render' => "<p><a href=\"/f%C3%B6%C3%B6\" title=\"föö\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-330' => [
                'input' =>  "``` f&ouml;&ouml;" . "\n" .
                            "foo" . "\n" .
                            "```",
                'render' => "<pre><code class=\"language-föö\">foo" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-331' => [
                'input' =>  "`f&ouml;&ouml;`",
                'render' => "<p><code>f&amp;ouml;&amp;ouml;</code></p>"
            ],
            'https://github.github.com/gfm/#example-332' => [
                'input' =>  "    f&ouml;f&ouml;",
                'render' => "<pre><code>f&amp;ouml;f&amp;ouml;" . "\n" .
                            "</code></pre>"
            ],
            'https://github.github.com/gfm/#example-333' => [
                'input' =>  "&#42;foo&#42;" . "\n" .
                            "*foo*",
                'render' => "<p>*foo*" . "\n" .
                            "<em>foo</em></p>"
            ],
            'https://github.github.com/gfm/#example-334' => [
                'input' =>  "&#42; foo" . "\n" .
                            "" . "\n" .
                            "* foo",
                'render' => "<p>* foo</p>" . "\n" .
                            "<ul>" . "\n" .
                            "<li>foo</li>" . "\n" .
                            "</ul>"
            ],
            'https://github.github.com/gfm/#example-335' => [
                'input' =>  "foo&#10;&#10;bar",
                'render' => "<p>foo" . "\n" .
                            "" . "\n" .
                            "bar</p>"
            ],
            'https://github.github.com/gfm/#example-336' => [
                'input' =>  "&#9;foo",
                'render' => "<p>\tfoo</p>"
            ],
            'https://github.github.com/gfm/#example-337' => [
                'input' =>  "[a](url &quot;tit&quot;)",
                'render' => "<p>[a](url &quot;tit&quot;)</p>"
            ],
        ];
    }

    public function dataCodeSpans(): array
    {
        return [
            'https://github.github.com/gfm/#example-338' => [
                'input' =>  "`foo`",
                'render' => "<p><code>foo</code></p>"
            ],
            'https://github.github.com/gfm/#example-339' => [
                'input' =>  "`` foo ` bar ``",
                'render' => "<p><code>foo ` bar</code></p>"
            ],
            'https://github.github.com/gfm/#example-340' => [
                'input' =>  "` `` `",
                'render' => "<p><code>``</code></p>"
            ],
            'https://github.github.com/gfm/#example-341' => [
                'input' =>  "`  ``  `",
                'render' => "<p><code> `` </code></p>"
            ],
            'https://github.github.com/gfm/#example-342' => [
                'input' =>  "` a`",
                'render' => "<p><code> a</code></p>"
            ],
            'https://github.github.com/gfm/#example-343' => [
                'input' =>  "` b `",
                'render' => "<p><code> b </code></p>"
            ],
            'https://github.github.com/gfm/#example-344' => [
                'input' =>  "` `" . "\n" .
                            "`  `",
                'render' => "<p><code> </code>" . "\n" .
                            "<code>  </code></p>"
            ],
            'https://github.github.com/gfm/#example-345' => [
                'input' =>  "``" . "\n" .
                            "foo" . "\n" .
                            "bar  " . "\n" .
                            "baz" . "\n" .
                            "``",
                'render' => "<p><code>foo bar   baz</code></p>"
            ],
            'https://github.github.com/gfm/#example-346' => [
                'input' =>  "``" . "\n" .
                            "foo " . "\n" .
                            "``",
                'render' => "<p><code>foo </code></p>"
            ],
            'https://github.github.com/gfm/#example-347' => [
                'input' =>  "`foo   bar " . "\n" .
                            "baz`",
                'render' => "<p><code>foo   bar  baz</code></p>"
            ],
            'https://github.github.com/gfm/#example-348' => [
                'input' =>  "`foo\`bar`",
                'render' => "<p><code>foo\</code>bar`</p>"
            ],
            'https://github.github.com/gfm/#example-349' => [
                'input' =>  "``foo`bar``",
                'render' => "<p><code>foo`bar</code></p>"
            ],
            'https://github.github.com/gfm/#example-350' => [
                'input' =>  "` foo `` bar `",
                'render' => "<p><code>foo `` bar</code></p>"
            ],
            'https://github.github.com/gfm/#example-351' => [
                'input' =>  "*foo`*`",
                'render' => "<p>*foo<code>*</code></p>"
            ],
            'https://github.github.com/gfm/#example-352' => [
                'input' =>  "[not a `link](/foo`)",
                'render' => "<p>[not a <code>link](/foo</code>)</p>"
            ],
            'https://github.github.com/gfm/#example-353' => [
                'input' =>  "`<a href=\"`\">`",
                'render' => "<p><code>&lt;a href=&quot;</code>&quot;&gt;`</p>"
            ],
            'https://github.github.com/gfm/#example-354' => [
                'input' =>  "<a href=\"`\">`",
                'render' => "<p><a href=\"`\">`</p>"
            ],
            'https://github.github.com/gfm/#example-355' => [
                'input' =>  "`<http://foo.bar.`baz>`",
                'render' => "<p><code>&lt;http://foo.bar.</code>baz&gt;`</p>"
            ],
            'https://github.github.com/gfm/#example-356' => [
                'input' =>  "<http://foo.bar.`baz>`",
                'render' => "<p><a href=\"http://foo.bar.%60baz\">http://foo.bar.`baz</a>`</p>"
            ],
            'https://github.github.com/gfm/#example-357' => [
                'input' =>  "```foo``",
                'render' => "<p>```foo``</p>"
            ],
            'https://github.github.com/gfm/#example-358' => [
                'input' =>  "`foo",
                'render' => "<p>`foo</p>"
            ],
            'https://github.github.com/gfm/#example-359' => [
                'input' =>  "`foo``bar``",
                'render' => "<p>`foo<code>bar</code></p>"
            ],
        ];
    }

    public function dataEmphasisAndStrongEmphasis(): array
    {
        return [
            'https://github.github.com/gfm/#example-360' => [
                'input' =>  "*foo bar*",
                'render' => "<p><em>foo bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-361' => [
                'input' =>  "a * foo bar*",
                'render' => "<p>a * foo bar*</p>"
            ],
            'https://github.github.com/gfm/#example-362' => [
                'input' =>  "a*\"foo\"*",
                'render' => "<p>a*&quot;foo&quot;*</p>"
            ],
            'https://github.github.com/gfm/#example-363' => [
                'input' =>  "* a *",
                'render' => "<p>* a *</p>"
            ],
            'https://github.github.com/gfm/#example-364' => [
                'input' =>  "foo*bar*",
                'render' => "<p>foo<em>bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-365' => [
                'input' =>  "5*6*78",
                'render' => "<p>5<em>6</em>78</p>"
            ],
            'https://github.github.com/gfm/#example-366' => [
                'input' =>  "_foo bar_",
                'render' => "<p><em>foo bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-367' => [
                'input' =>  "_ foo bar_",
                'render' => "<p>_ foo bar_</p>"
            ],
            'https://github.github.com/gfm/#example-368' => [
                'input' =>  "a_\"foo\"_",
                'render' => "<p>a_&quot;foo&quot;_</p>"
            ],
            'https://github.github.com/gfm/#example-369' => [
                'input' =>  "foo_bar_",
                'render' => "<p>foo_bar_</p>"
            ],
            'https://github.github.com/gfm/#example-370' => [
                'input' =>  "5_6_78",
                'render' => "<p>5_6_78</p>"
            ],
            'https://github.github.com/gfm/#example-371' => [
                'input' =>  "пристаням_стремятся_",
                'render' => "<p>пристаням_стремятся_</p>"
            ],
            'https://github.github.com/gfm/#example-372' => [
                'input' =>  "aa_\"bb\"_cc",
                'render' => "<p>aa_&quot;bb&quot;_cc</p>"
            ],
            'https://github.github.com/gfm/#example-373' => [
                'input' =>  "foo-_(bar)_",
                'render' => "<p>foo-<em>(bar)</em></p>"
            ],
            'https://github.github.com/gfm/#example-374' => [
                'input' =>  "_foo*",
                'render' => "<p>_foo*</p>"
            ],
            'https://github.github.com/gfm/#example-375' => [
                'input' =>  "*foo bar *",
                'render' => "<p>*foo bar *</p>"
            ],
            'https://github.github.com/gfm/#example-376' => [
                'input' =>  "*foo bar" . "\n" .
                            "*",
                'render' => "<p>*foo bar" . "\n" .
                            "*</p>"
            ],
            'https://github.github.com/gfm/#example-377' => [
                'input' =>  "*(*foo)",
                'render' => "<p>*(*foo)</p>"
            ],
            'https://github.github.com/gfm/#example-378' => [
                'input' =>  "*(*foo*)*",
                'render' => "<p><em>(<em>foo</em>)</em></p>"
            ],
            'https://github.github.com/gfm/#example-379' => [
                'input' =>  "*foo*bar",
                'render' => "<p><em>foo</em>bar</p>"
            ],
            'https://github.github.com/gfm/#example-380' => [
                'input' =>  "_foo bar _",
                'render' => "<p>_foo bar _</p>"
            ],
            'https://github.github.com/gfm/#example-381' => [
                'input' =>  "_(_foo)",
                'render' => "<p>_(_foo)</p>"
            ],
            'https://github.github.com/gfm/#example-382' => [
                'input' =>  "_(_foo_)_",
                'render' => "<p><em>(<em>foo</em>)</em></p>"
            ],
            'https://github.github.com/gfm/#example-383' => [
                'input' =>  "_foo_bar",
                'render' => "<p>_foo_bar</p>"
            ],
            'https://github.github.com/gfm/#example-384' => [
                'input' =>  "_пристаням_стремятся",
                'render' => "<p>_пристаням_стремятся</p>"
            ],
            'https://github.github.com/gfm/#example-385' => [
                'input' =>  "_foo_bar_baz_",
                'render' => "<p><em>foo_bar_baz</em></p>"
            ],
            'https://github.github.com/gfm/#example-386' => [
                'input' =>  "_(bar)_.",
                'render' => "<p><em>(bar)</em>.</p>"
            ],
            'https://github.github.com/gfm/#example-387' => [
                'input' =>  "**foo bar**",
                'render' => "<p><strong>foo bar</strong></p>"
            ],
            'https://github.github.com/gfm/#example-388' => [
                'input' =>  "** foo bar**",
                'render' => "<p>** foo bar**</p>"
            ],
            'https://github.github.com/gfm/#example-389' => [
                'input' =>  "a**\"foo\"**",
                'render' => "<p>a**&quot;foo&quot;**</p>"
            ],
            'https://github.github.com/gfm/#example-390' => [
                'input' =>  "foo**bar**",
                'render' => "<p>foo<strong>bar</strong></p>"
            ],
            'https://github.github.com/gfm/#example-391' => [
                'input' =>  "__foo bar__",
                'render' => "<p><strong>foo bar</strong></p>"
            ],
            'https://github.github.com/gfm/#example-392' => [
                'input' =>  "__ foo bar__",
                'render' => "<p>__ foo bar__</p>"
            ],
            'https://github.github.com/gfm/#example-393' => [
                'input' =>  "__" . "\n" .
                            "foo bar__",
                'render' => "<p>__" . "\n" .
                            "foo bar__</p>"
            ],
            'https://github.github.com/gfm/#example-394' => [
                'input' =>  "a__\"foo\"__",
                'render' => "<p>a__&quot;foo&quot;__</p>"
            ],
            'https://github.github.com/gfm/#example-395' => [
                'input' =>  "foo__bar__",
                'render' => "<p>foo__bar__</p>"
            ],
            'https://github.github.com/gfm/#example-396' => [
                'input' =>  "5__6__78",
                'render' => "<p>5__6__78</p>"
            ],
            'https://github.github.com/gfm/#example-397' => [
                'input' =>  "пристаням__стремятся__",
                'render' => "<p>пристаням__стремятся__</p>"
            ],
            'https://github.github.com/gfm/#example-398' => [
                'input' =>  "__foo, __bar__, baz__",
                'render' => "<p><strong>foo, <strong>bar</strong>, baz</strong></p>"
            ],
            'https://github.github.com/gfm/#example-399' => [
                'input' =>  "foo-__(bar)__",
                'render' => "<p>foo-<strong>(bar)</strong></p>"
            ],
            'https://github.github.com/gfm/#example-400' => [
                'input' =>  "**foo bar **",
                'render' => "<p>**foo bar **</p>"
            ],
            'https://github.github.com/gfm/#example-401' => [
                'input' =>  "**(**foo)",
                'render' => "<p>**(**foo)</p>"
            ],
            'https://github.github.com/gfm/#example-402' => [
                'input' =>  "*(**foo**)*",
                'render' => "<p><em>(<strong>foo</strong>)</em></p>"
            ],
            'https://github.github.com/gfm/#example-403' => [
                'input' =>  "**Gomphocarpus (*Gomphocarpus physocarpus*, syn." . "\n" .
                            "*Asclepias physocarpa*)**",
                'render' => "<p><strong>Gomphocarpus (<em>Gomphocarpus physocarpus</em>, syn." . "\n" .
                            "<em>Asclepias physocarpa</em>)</strong></p>"
            ],
            'https://github.github.com/gfm/#example-404' => [
                'input' =>  "**foo \"*bar*\" foo**",
                'render' => "<p><strong>foo &quot;<em>bar</em>&quot; foo</strong></p>"
            ],
            'https://github.github.com/gfm/#example-405' => [
                'input' =>  "**foo**bar",
                'render' => "<p><strong>foo</strong>bar</p>"
            ],
            'https://github.github.com/gfm/#example-406' => [
                'input' =>  "__foo bar __",
                'render' => "<p>__foo bar __</p>"
            ],
            'https://github.github.com/gfm/#example-407' => [
                'input' =>  "__(__foo)",
                'render' => "<p>__(__foo)</p>"
            ],
            'https://github.github.com/gfm/#example-408' => [
                'input' =>  "_(__foo__)_",
                'render' => "<p><em>(<strong>foo</strong>)</em></p>"
            ],
            'https://github.github.com/gfm/#example-409' => [
                'input' =>  "__foo__bar",
                'render' => "<p>__foo__bar</p>"
            ],
            'https://github.github.com/gfm/#example-410' => [
                'input' =>  "__пристаням__стремятся",
                'render' => "<p>__пристаням__стремятся</p>"
            ],
            'https://github.github.com/gfm/#example-411' => [
                'input' =>  "__foo__bar__baz__",
                'render' => "<p><strong>foo__bar__baz</strong></p>"
            ],
            'https://github.github.com/gfm/#example-412' => [
                'input' =>  "__(bar)__.",
                'render' => "<p><strong>(bar)</strong>.</p>"
            ],
            'https://github.github.com/gfm/#example-413' => [
                'input' =>  "*foo [bar](/url)*",
                'render' => "<p><em>foo <a href=\"/url\">bar</a></em></p>"
            ],
            'https://github.github.com/gfm/#example-414' => [
                'input' =>  "*foo" . "\n" .
                            "bar*",
                'render' => "<p><em>foo" . "\n" .
                            "bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-415' => [
                'input' =>  "_foo __bar__ baz_",
                'render' => "<p><em>foo <strong>bar</strong> baz</em></p>"
            ],
            'https://github.github.com/gfm/#example-416' => [
                'input' =>  "_foo _bar_ baz_",
                'render' => "<p><em>foo <em>bar</em> baz</em></p>"
            ],
            'https://github.github.com/gfm/#example-417' => [
                'input' =>  "__foo_ bar_",
                'render' => "<p><em><em>foo</em> bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-418' => [
                'input' =>  "*foo *bar**",
                'render' => "<p><em>foo <em>bar</em></em></p>"
            ],
            'https://github.github.com/gfm/#example-419' => [
                'input' =>  "*foo **bar** baz*",
                'render' => "<p><em>foo <strong>bar</strong> baz</em></p>"
            ],
            'https://github.github.com/gfm/#example-420' => [
                'input' =>  "*foo**bar**baz*",
                'render' => "<p><em>foo<strong>bar</strong>baz</em></p>"
            ],
            'https://github.github.com/gfm/#example-421' => [
                'input' =>  "*foo**bar*",
                'render' => "<p><em>foo**bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-422' => [
                'input' =>  "***foo** bar*",
                'render' => "<p><em><strong>foo</strong> bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-423' => [
                'input' =>  "*foo **bar***",
                'render' => "<p><em>foo <strong>bar</strong></em></p>"
            ],
            'https://github.github.com/gfm/#example-424' => [
                'input' =>  "*foo**bar***",
                'render' => "<p><em>foo<strong>bar</strong></em></p>"
            ],
            'https://github.github.com/gfm/#example-425' => [
                'input' =>  "foo***bar***baz",
                'render' => "<p>foo<em><strong>bar</strong></em>baz</p>"
            ],
            'https://github.github.com/gfm/#example-426' => [
                'input' =>  "foo******bar*********baz",
                'render' => "<p>foo<strong><strong><strong>bar</strong></strong></strong>***baz</p>"
            ],
            'https://github.github.com/gfm/#example-427' => [
                'input' =>  "*foo **bar *baz* bim** bop*",
                'render' => "<p><em>foo <strong>bar <em>baz</em> bim</strong> bop</em></p>"
            ],
            'https://github.github.com/gfm/#example-428' => [
                'input' =>  "*foo [*bar*](/url)*",
                'render' => "<p><em>foo <a href=\"/url\"><em>bar</em></a></em></p>"
            ],
            'https://github.github.com/gfm/#example-429' => [
                'input' =>  "** is not an empty emphasis",
                'render' => "<p>** is not an empty emphasis</p>"
            ],
            'https://github.github.com/gfm/#example-430' => [
                'input' =>  "**** is not an empty strong emphasis",
                'render' => "<p>**** is not an empty strong emphasis</p>"
            ],
            'https://github.github.com/gfm/#example-431' => [
                'input' =>  "**foo [bar](/url)**",
                'render' => "<p><strong>foo <a href=\"/url\">bar</a></strong></p>"
            ],
            'https://github.github.com/gfm/#example-432' => [
                'input' =>  "**foo" . "\n" .
                            "bar**",
                'render' => "<p><strong>foo" . "\n" .
                            "bar</strong></p>"
            ],
            'https://github.github.com/gfm/#example-433' => [
                'input' =>  "__foo _bar_ baz__",
                'render' => "<p><strong>foo <em>bar</em> baz</strong></p>"
            ],
            'https://github.github.com/gfm/#example-434' => [
                'input' =>  "__foo __bar__ baz__",
                'render' => "<p><strong>foo <strong>bar</strong> baz</strong></p>"
            ],
            'https://github.github.com/gfm/#example-435' => [
                'input' =>  "____foo__ bar__",
                'render' => "<p><strong><strong>foo</strong> bar</strong></p>"
            ],
            'https://github.github.com/gfm/#example-436' => [
                'input' =>  "**foo **bar****",
                'render' => "<p><strong>foo <strong>bar</strong></strong></p>"
            ],
            'https://github.github.com/gfm/#example-437' => [
                'input' =>  "**foo *bar* baz**",
                'render' => "<p><strong>foo <em>bar</em> baz</strong></p>"
            ],
            'https://github.github.com/gfm/#example-438' => [
                'input' =>  "**foo*bar*baz**",
                'render' => "<p><strong>foo<em>bar</em>baz</strong></p>"
            ],
            'https://github.github.com/gfm/#example-439' => [
                'input' =>  "***foo* bar**",
                'render' => "<p><strong><em>foo</em> bar</strong></p>"
            ],
            'https://github.github.com/gfm/#example-440' => [
                'input' =>  "**foo *bar***",
                'render' => "<p><strong>foo <em>bar</em></strong></p>"
            ],
            'https://github.github.com/gfm/#example-441' => [
                'input' =>  "**foo *bar **baz**" . "\n" .
                            "bim* bop**",
                'render' => "<p><strong>foo <em>bar <strong>baz</strong>" . "\n" .
                            "bim</em> bop</strong></p>"
            ],
            'https://github.github.com/gfm/#example-442' => [
                'input' =>  "**foo [*bar*](/url)**",
                'render' => "<p><strong>foo <a href=\"/url\"><em>bar</em></a></strong></p>"
            ],
            'https://github.github.com/gfm/#example-443' => [
                'input' =>  "__ is not an empty emphasis",
                'render' => "<p>__ is not an empty emphasis</p>"
            ],
            'https://github.github.com/gfm/#example-444' => [
                'input' =>  "____ is not an empty strong emphasis",
                'render' => "<p>____ is not an empty strong emphasis</p>"
            ],
            'https://github.github.com/gfm/#example-445' => [
                'input' =>  "foo ***",
                'render' => "<p>foo ***</p>"
            ],
            'https://github.github.com/gfm/#example-446' => [
                'input' =>  "foo *\**",
                'render' => "<p>foo <em>*</em></p>"
            ],
            'https://github.github.com/gfm/#example-447' => [
                'input' =>  "foo *_*",
                'render' => "<p>foo <em>_</em></p>"
            ],
            'https://github.github.com/gfm/#example-448' => [
                'input' =>  "foo *****",
                'render' => "<p>foo *****</p>"
            ],
            'https://github.github.com/gfm/#example-449' => [
                'input' =>  "foo **\***",
                'render' => "<p>foo <strong>*</strong></p>"
            ],
            'https://github.github.com/gfm/#example-450' => [
                'input' =>  "foo **_**",
                'render' => "<p>foo <strong>_</strong></p>"
            ],
            'https://github.github.com/gfm/#example-451' => [
                'input' =>  "**foo*",
                'render' => "<p>*<em>foo</em></p>"
            ],
            'https://github.github.com/gfm/#example-452' => [
                'input' =>  "*foo**",
                'render' => "<p><em>foo</em>*</p>"
            ],
            'https://github.github.com/gfm/#example-453' => [
                'input' =>  "***foo**",
                'render' => "<p>*<strong>foo</strong></p>"
            ],
            'https://github.github.com/gfm/#example-454' => [
                'input' =>  "****foo*",
                'render' => "<p>***<em>foo</em></p>"
            ],
            'https://github.github.com/gfm/#example-455' => [
                'input' =>  "**foo***",
                'render' => "<p><strong>foo</strong>*</p>"
            ],
            'https://github.github.com/gfm/#example-456' => [
                'input' =>  "*foo****",
                'render' => "<p><em>foo</em>***</p>"
            ],
            'https://github.github.com/gfm/#example-457' => [
                'input' =>  "foo ___",
                'render' => "<p>foo ___</p>"
            ],
            'https://github.github.com/gfm/#example-458' => [
                'input' =>  "foo _\__",
                'render' => "<p>foo <em>_</em></p>"
            ],
            'https://github.github.com/gfm/#example-459' => [
                'input' =>  "foo _*_",
                'render' => "<p>foo <em>*</em></p>"
            ],
            'https://github.github.com/gfm/#example-460' => [
                'input' =>  "foo _____",
                'render' => "<p>foo _____</p>"
            ],
            'https://github.github.com/gfm/#example-461' => [
                'input' =>  "foo __\___",
                'render' => "<p>foo <strong>_</strong></p>"
            ],
            'https://github.github.com/gfm/#example-462' => [
                'input' =>  "foo __*__",
                'render' => "<p>foo <strong>*</strong></p>"
            ],
            'https://github.github.com/gfm/#example-463' => [
                'input' =>  "__foo_",
                'render' => "<p>_<em>foo</em></p>"
            ],
            'https://github.github.com/gfm/#example-464' => [
                'input' =>  "_foo__",
                'render' => "<p><em>foo</em>_</p>"
            ],
            'https://github.github.com/gfm/#example-465' => [
                'input' =>  "___foo__",
                'render' => "<p>_<strong>foo</strong></p>"
            ],
            'https://github.github.com/gfm/#example-466' => [
                'input' =>  "____foo_",
                'render' => "<p>___<em>foo</em></p>"
            ],
            'https://github.github.com/gfm/#example-467' => [
                'input' =>  "__foo___",
                'render' => "<p><strong>foo</strong>_</p>"
            ],
            'https://github.github.com/gfm/#example-468' => [
                'input' =>  "_foo____",
                'render' => "<p><em>foo</em>___</p>"
            ],
            'https://github.github.com/gfm/#example-469' => [
                'input' =>  "**foo**",
                'render' => "<p><strong>foo</strong></p>"
            ],
            'https://github.github.com/gfm/#example-470' => [
                'input' =>  "*_foo_*",
                'render' => "<p><em><em>foo</em></em></p>"
            ],
            'https://github.github.com/gfm/#example-471' => [
                'input' =>  "__foo__",
                'render' => "<p><strong>foo</strong></p>"
            ],
            'https://github.github.com/gfm/#example-472' => [
                'input' =>  "_*foo*_",
                'render' => "<p><em><em>foo</em></em></p>"
            ],
            'https://github.github.com/gfm/#example-473' => [
                'input' =>  "****foo****",
                'render' => "<p><strong><strong>foo</strong></strong></p>"
            ],
            'https://github.github.com/gfm/#example-474' => [
                'input' =>  "____foo____",
                'render' => "<p><strong><strong>foo</strong></strong></p>"
            ],
            'https://github.github.com/gfm/#example-475' => [
                'input' =>  "******foo******",
                'render' => "<p><strong><strong><strong>foo</strong></strong></strong></p>"
            ],
            'https://github.github.com/gfm/#example-476' => [
                'input' =>  "***foo***",
                'render' => "<p><em><strong>foo</strong></em></p>"
            ],
            'https://github.github.com/gfm/#example-477' => [
                'input' =>  "_____foo_____",
                'render' => "<p><em><strong><strong>foo</strong></strong></em></p>"
            ],
            'https://github.github.com/gfm/#example-478' => [
                'input' =>  "*foo _bar* baz_",
                'render' => "<p><em>foo _bar</em> baz_</p>"
            ],
            'https://github.github.com/gfm/#example-479' => [
                'input' =>  "*foo __bar *baz bim__ bam*",
                'render' => "<p><em>foo <strong>bar *baz bim</strong> bam</em></p>"
            ],
            'https://github.github.com/gfm/#example-480' => [
                'input' =>  "**foo **bar baz**",
                'render' => "<p>**foo <strong>bar baz</strong></p>"
            ],
            'https://github.github.com/gfm/#example-481' => [
                'input' =>  "*foo *bar baz*",
                'render' => "<p>*foo <em>bar baz</em></p>"
            ],
            'https://github.github.com/gfm/#example-482' => [
                'input' =>  "*[bar*](/url)",
                'render' => "<p>*<a href=\"/url\">bar*</a></p>"
            ],
            'https://github.github.com/gfm/#example-483' => [
                'input' =>  "_foo [bar_](/url)",
                'render' => "<p>_foo <a href=\"/url\">bar_</a></p>"
            ],
            'https://github.github.com/gfm/#example-484' => [
                'input' =>  "*<img src=\"foo\" title=\"*\"/>",
                'render' => "<p>*<img src=\"foo\" title=\"*\"/></p>"
            ],
            'https://github.github.com/gfm/#example-485' => [
                'input' =>  "**<a href=\"**\">",
                'render' => "<p>**<a href=\"**\"></p>"
            ],
            'https://github.github.com/gfm/#example-486' => [
                'input' =>  "__<a href=\"__\">",
                'render' => "<p>__<a href=\"__\"></p>"
            ],
            'https://github.github.com/gfm/#example-487' => [
                'input' =>  "*a `*`*",
                'render' => "<p><em>a <code>*</code></em></p>"
            ],
            'https://github.github.com/gfm/#example-488' => [
                'input' =>  "_a `_`_",
                'render' => "<p><em>a <code>_</code></em></p>"
            ],
            'https://github.github.com/gfm/#example-489' => [
                'input' =>  "**a<http://foo.bar/?q=**>",
                'render' => "<p>**a<a href=\"http://foo.bar/?q=**\">http://foo.bar/?q=**</a></p>"
            ],
            'https://github.github.com/gfm/#example-490' => [
                'input' =>  "__a<http://foo.bar/?q=__>",
                'render' => "<p>__a<a href=\"http://foo.bar/?q=__\">http://foo.bar/?q=__</a></p>"
            ],
        ];
    }

    public function dataStrikethrough(): array
    {
        return [
            'https://github.github.com/gfm/#example-491' => [
                'input' =>  "~~Hi~~ Hello, world!",
                'render' => "<p><del>Hi</del> Hello, world!</p>"
            ],
            'https://github.github.com/gfm/#example-492' => [
                'input' =>  "This ~~has a" . "\n" .
                            "" . "\n" .
                            "new paragraph~~.",
                'render' => "<p>This ~~has a</p>" . "\n" .
                            "<p>new paragraph~~.</p>"
            ],
        ];
    }

    public function dataLinks(): array
    {
        return [
            'https://github.github.com/gfm/#example-493' => [
                'input' =>  "[link](/uri \"title\")",
                'render' => "<p><a href=\"/uri\" title=\"title\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-494' => [
                'input' =>  "[link](/uri)",
                'render' => "<p><a href=\"/uri\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-495' => [
                'input' =>  "[link]()",
                'render' => "<p><a href=\"\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-496' => [
                'input' =>  "[link](<>)",
                'render' => "<p><a href=\"\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-497' => [
                'input' =>  "[link](/my uri)",
                'render' => "<p>[link](/my uri)</p>"
            ],
            'https://github.github.com/gfm/#example-498' => [
                'input' =>  "[link](</my uri>)",
                'render' => "<p><a href=\"/my%20uri\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-499' => [
                'input' =>  "[link](foo" . "\n" .
                            "bar)",
                'render' => "<p>[link](foo" . "\n" .
                            "bar)</p>"
            ],
            'https://github.github.com/gfm/#example-500' => [
                'input' =>  "[link](<foo" . "\n" .
                            "bar>)",
                'render' => "<p>[link](<foo" . "\n" .
                            "bar>)</p>"
            ],
            'https://github.github.com/gfm/#example-501' => [
                'input' =>  "[a](<b)c>)",
                'render' => "<p><a href=\"b)c\">a</a></p>"
            ],
            'https://github.github.com/gfm/#example-502' => [
                'input' =>  "[link](<foo\>)",
                'render' => "<p>[link](&lt;foo&gt;)</p>"
            ],
            'https://github.github.com/gfm/#example-503' => [
                'input' =>  "[a](<b)c" . "\n" .
                            "[a](<b)c>" . "\n" .
                            "[a](<b>c)",
                'render' => "<p>[a](&lt;b)c" . "\n" .
                            "[a](&lt;b)c&gt;" . "\n" .
                            "[a](<b>c)</p>"
            ],
            'https://github.github.com/gfm/#example-504' => [
                'input' =>  "[link](\(foo\))",
                'render' => "<p><a href=\"(foo)\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-505' => [
                'input' =>  "[link](foo(and(bar)))",
                'render' => "<p><a href=\"foo(and(bar))\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-506' => [
                'input' =>  "[link](foo\(and\(bar\))",
                'render' => "<p><a href=\"foo(and(bar)\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-507' => [
                'input' =>  "[link](<foo(and(bar)>)",
                'render' => "<p><a href=\"foo(and(bar)\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-508' => [
                'input' =>  "[link](foo\)\:)",
                'render' => "<p><a href=\"foo):\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-509' => [
                'input' =>  "[link](#fragment)" . "\n" .
                            "" . "\n" .
                            "[link](http://example.com#fragment)" . "\n" .
                            "" . "\n" .
                            "[link](http://example.com?foo=3#frag)",
                'render' => "<p><a href=\"#fragment\">link</a></p>" . "\n" .
                            "<p><a href=\"http://example.com#fragment\">link</a></p>" . "\n" .
                            "<p><a href=\"http://example.com?foo=3#frag\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-510' => [
                'input' =>  "[link](foo\bar)",
                'render' => "<p><a href=\"foo%5Cbar\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-511' => [
                'input' =>  "[link](foo%20b&auml;)",
                'render' => "<p><a href=\"foo%20b%C3%A4\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-512' => [
                'input' =>  "[link](\"title\")",
                'render' => "<p><a href=\"%22title%22\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-513' => [
                'input' =>  "[link](/url \"title\")" . "\n" .
                            "[link](/url 'title')" . "\n" .
                            "[link](/url (title))",
                'render' => "<p><a href=\"/url\" title=\"title\">link</a>" . "\n" .
                            "<a href=\"/url\" title=\"title\">link</a>" . "\n" .
                            "<a href=\"/url\" title=\"title\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-514' => [
                'input' =>  "[link](/url \"title \"&quot;\")",
                'render' => "<p><a href=\"/url\" title=\"title &quot;&quot;\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-515' => [
                'input' =>  "[link](/url \"title\")",
                'render' => "<p><a href=\"/url%C2%A0%22title%22\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-516' => [
                'input' =>  "[link](/url \"title \"and\" title\")",
                'render' => "<p>[link](/url &quot;title &quot;and&quot; title&quot;)</p>"
            ],
            'https://github.github.com/gfm/#example-517' => [
                'input' =>  "[link](/url 'title \"and\" title')",
                'render' => "<p><a href=\"/url\" title=\"title &quot;and&quot; title\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-518' => [
                'input' =>  "[link](   /uri" . "\n" .
                            "  \"title\"  )",
                'render' => "<p><a href=\"/uri\" title=\"title\">link</a></p>"
            ],
            'https://github.github.com/gfm/#example-519' => [
                'input' =>  "[link] (/uri)",
                'render' => "<p>[link] (/uri)</p>"
            ],
            'https://github.github.com/gfm/#example-520' => [
                'input' =>  "[link [foo [bar]]](/uri)",
                'render' => "<p><a href=\"/uri\">link [foo [bar]]</a></p>"
            ],
            'https://github.github.com/gfm/#example-521' => [
                'input' =>  "[link] bar](/uri)",
                'render' => "<p>[link] bar](/uri)</p>"
            ],
            'https://github.github.com/gfm/#example-522' => [
                'input' =>  "[link [bar](/uri)",
                'render' => "<p>[link <a href=\"/uri\">bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-523' => [
                'input' =>  "[link \[bar](/uri)",
                'render' => "<p><a href=\"/uri\">link [bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-524' => [
                'input' =>  "[link *foo **bar** `#`*](/uri)",
                'render' => "<p><a href=\"/uri\">link <em>foo <strong>bar</strong> <code>#</code></em></a></p>"
            ],
            'https://github.github.com/gfm/#example-525' => [
                'input' =>  "[![moon](moon.jpg)](/uri)",
                'render' => "<p><a href=\"/uri\"><img src=\"moon.jpg\" alt=\"moon\" /></a></p>"
            ],
            'https://github.github.com/gfm/#example-526' => [
                'input' =>  "[foo [bar](/uri)](/uri)",
                'render' => "<p>[foo <a href=\"/uri\">bar</a>](/uri)</p>"
            ],
            'https://github.github.com/gfm/#example-527' => [
                'input' =>  "[foo *[bar [baz](/uri)](/uri)*](/uri)",
                'render' => "<p>[foo <em>[bar <a href=\"/uri\">baz</a>](/uri)</em>](/uri)</p>"
            ],
            'https://github.github.com/gfm/#example-528' => [
                'input' =>  "![[[foo](uri1)](uri2)](uri3)",
                'render' => "<p><img src=\"uri3\" alt=\"[foo](uri2)\" /></p>"
            ],
            'https://github.github.com/gfm/#example-529' => [
                'input' =>  "*[foo*](/uri)",
                'render' => "<p>*<a href=\"/uri\">foo*</a></p>"
            ],
            'https://github.github.com/gfm/#example-530' => [
                'input' =>  "[foo *bar](baz*)",
                'render' => "<p><a href=\"baz*\">foo *bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-531' => [
                'input' =>  "*foo [bar* baz]",
                'render' => "<p><em>foo [bar</em> baz]</p>"
            ],
            'https://github.github.com/gfm/#example-532' => [
                'input' =>  "[foo <bar attr=\"](baz)\">",
                'render' => "<p>[foo <bar attr=\"](baz)\"></p>"
            ],
            'https://github.github.com/gfm/#example-533' => [
                'input' =>  "[foo`](/uri)`",
                'render' => "<p>[foo<code>](/uri)</code></p>"
            ],
            'https://github.github.com/gfm/#example-534' => [
                'input' =>  "[foo<http://example.com/?search=](uri)>",
                'render' => "<p>[foo<a href=\"http://example.com/?search=%5D(uri)\">http://example.com/?search=](uri)</a></p>"
            ],
            'https://github.github.com/gfm/#example-535' => [
                'input' =>  "[foo][bar]" . "\n" .
                            "" . "\n" .
                            "[bar]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-536' => [
                'input' =>  "[link [foo [bar]]][ref]" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p><a href=\"/uri\">link [foo [bar]]</a></p>"
            ],
            'https://github.github.com/gfm/#example-537' => [
                'input' =>  "[link \[bar][ref]" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p><a href=\"/uri\">link [bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-538' => [
                'input' =>  "[link *foo **bar** `#`*][ref]" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p><a href=\"/uri\">link <em>foo <strong>bar</strong> <code>#</code></em></a></p>"
            ],
            'https://github.github.com/gfm/#example-539' => [
                'input' =>  "[![moon](moon.jpg)][ref]" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p><a href=\"/uri\"><img src=\"moon.jpg\" alt=\"moon\" /></a></p>"
            ],
            'https://github.github.com/gfm/#example-540' => [
                'input' =>  "[foo [bar](/uri)][ref]" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p>[foo <a href=\"/uri\">bar</a>]<a href=\"/uri\">ref</a></p>"
            ],
            'https://github.github.com/gfm/#example-541' => [
                'input' =>  "[foo *bar [baz][ref]*][ref]" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p>[foo <em>bar <a href=\"/uri\">baz</a></em>]<a href=\"/uri\">ref</a></p>"
            ],
            'https://github.github.com/gfm/#example-542' => [
                'input' =>  "*[foo*][ref]" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p>*<a href=\"/uri\">foo*</a></p>"
            ],
            'https://github.github.com/gfm/#example-543' => [
                'input' =>  "[foo *bar][ref]*" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p><a href=\"/uri\">foo *bar</a>*</p>"
            ],
            'https://github.github.com/gfm/#example-544' => [
                'input' =>  "[foo <bar attr=\"][ref]\">" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p>[foo <bar attr=\"][ref]\"></p>"
            ],
            'https://github.github.com/gfm/#example-545' => [
                'input' =>  "[foo`][ref]`" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p>[foo<code>][ref]</code></p>"
            ],
            'https://github.github.com/gfm/#example-546' => [
                'input' =>  "[foo<http://example.com/?search=][ref]>" . "\n" .
                            "" . "\n" .
                            "[ref]: /uri",
                'render' => "<p>[foo<a href=\"http://example.com/?search=%5D%5Bref%5D\">http://example.com/?search=][ref]</a></p>"
            ],
            'https://github.github.com/gfm/#example-547' => [
                'input' =>  "[foo][BaR]" . "\n" .
                            "" . "\n" .
                            "[bar]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-548' => [
                'input' =>  "[ẞ]" . "\n" .
                            "" . "\n" .
                            "[SS]: /url",
                'render' => "<p><a href=\"/url\">ẞ</a></p>"
            ],
            'https://github.github.com/gfm/#example-549' => [
                'input' =>  "[Foo" . "\n" .
                            "  bar]: /url" . "\n" .
                            "" . "\n" .
                            "[Baz][Foo bar]",
                'render' => "<p><a href=\"/url\">Baz</a></p>"
            ],
            'https://github.github.com/gfm/#example-550' => [
                'input' =>  "[foo] [bar]" . "\n" .
                            "" . "\n" .
                            "[bar]: /url \"title\"",
                'render' => "<p>[foo] <a href=\"/url\" title=\"title\">bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-551' => [
                'input' =>  "[foo]" . "\n" .
                            "[bar]" . "\n" .
                            "" . "\n" .
                            "[bar]: /url \"title\"",
                'render' => "<p>[foo]" . "\n" .
                            "<a href=\"/url\" title=\"title\">bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-552' => [
                'input' =>  "[foo]: /url1" . "\n" .
                            "" . "\n" .
                            "[foo]: /url2" . "\n" .
                            "" . "\n" .
                            "[bar][foo]",
                'render' => "<p><a href=\"/url1\">bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-553' => [
                'input' =>  "[bar][foo\!]" . "\n" .
                            "" . "\n" .
                            "[foo!]: /url",
                'render' => "<p>[bar][foo!]</p>"
            ],
            'https://github.github.com/gfm/#example-554' => [
                'input' =>  "[foo][ref[]" . "\n" .
                            "" . "\n" .
                            "[ref[]: /uri",
                'render' => "<p>[foo][ref[]</p>" . "\n" .
                            "<p>[ref[]: /uri</p>"
            ],
            'https://github.github.com/gfm/#example-555' => [
                'input' =>  "[foo][ref[bar]]" . "\n" .
                            "" . "\n" .
                            "[ref[bar]]: /uri",
                'render' => "<p>[foo][ref[bar]]</p>" . "\n" .
                            "<p>[ref[bar]]: /uri</p>"
            ],
            'https://github.github.com/gfm/#example-556' => [
                'input' =>  "[[[foo]]]" . "\n" .
                            "" . "\n" .
                            "[[[foo]]]: /url",
                'render' => "<p>[[[foo]]]</p>" . "\n" .
                            "<p>[[[foo]]]: /url</p>"
            ],
            'https://github.github.com/gfm/#example-557' => [
                'input' =>  "[foo][ref\[]" . "\n" .
                            "" . "\n" .
                            "[ref\[]: /uri",
                'render' => "<p><a href=\"/uri\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-558' => [
                'input' =>  "[bar\\]: /uri" . "\n" .
                            "" . "\n" .
                            "[bar\\]",
                'render' => "<p><a href=\"/uri\">bar\</a></p>"
            ],
            'https://github.github.com/gfm/#example-559' => [
                'input' =>  "[]" . "\n" .
                            "" . "\n" .
                            "[]: /uri",
                'render' => "<p>[]</p>" . "\n" .
                            "<p>[]: /uri</p>"
            ],
            'https://github.github.com/gfm/#example-560' => [
                'input' =>  "[" . "\n" .
                            " ]" . "\n" .
                            "" . "\n" .
                            "[" . "\n" .
                            " ]: /uri",
                'render' => "<p>[" . "\n" .
                            "]</p>" . "\n" .
                            "<p>[" . "\n" .
                            "]: /uri</p>"
            ],
            'https://github.github.com/gfm/#example-561' => [
                'input' =>  "[foo][]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-562' => [
                'input' =>  "[*foo* bar][]" . "\n" .
                            "" . "\n" .
                            "[*foo* bar]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\"><em>foo</em> bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-563' => [
                'input' =>  "[Foo][]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\">Foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-564' => [
                'input' =>  "[foo] " . "\n" .
                            "[]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\">foo</a>" . "\n" .
                            "[]</p>"
            ],
            'https://github.github.com/gfm/#example-565' => [
                'input' =>  "[foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-566' => [
                'input' =>  "[*foo* bar]" . "\n" .
                            "" . "\n" .
                            "[*foo* bar]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\"><em>foo</em> bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-567' => [
                'input' =>  "[[*foo* bar]]" . "\n" .
                            "" . "\n" .
                            "[*foo* bar]: /url \"title\"",
                'render' => "<p>[<a href=\"/url\" title=\"title\"><em>foo</em> bar</a>]</p>"
            ],
            'https://github.github.com/gfm/#example-568' => [
                'input' =>  "[[bar [foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url",
                'render' => "<p>[[bar <a href=\"/url\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-569' => [
                'input' =>  "[Foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><a href=\"/url\" title=\"title\">Foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-570' => [
                'input' =>  "[foo] bar" . "\n" .
                            "" . "\n" .
                            "[foo]: /url",
                'render' => "<p><a href=\"/url\">foo</a> bar</p>"
            ],
            'https://github.github.com/gfm/#example-571' => [
                'input' =>  "\[foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p>[foo]</p>"
            ],
            'https://github.github.com/gfm/#example-572' => [
                'input' =>  "[foo*]: /url" . "\n" .
                            "" . "\n" .
                            "*[foo*]",
                'render' => "<p>*<a href=\"/url\">foo*</a></p>"
            ],
            'https://github.github.com/gfm/#example-573' => [
                'input' =>  "[foo][bar]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url1" . "\n" .
                            "[bar]: /url2",
                'render' => "<p><a href=\"/url2\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-574' => [
                'input' =>  "[foo][]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url1",
                'render' => "<p><a href=\"/url1\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-575' => [
                'input' =>  "[foo]()" . "\n" .
                            "" . "\n" .
                            "[foo]: /url1",
                'render' => "<p><a href=\"\">foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-576' => [
                'input' =>  "[foo](not a link)" . "\n" .
                            "" . "\n" .
                            "[foo]: /url1",
                'render' => "<p><a href=\"/url1\">foo</a>(not a link)</p>"
            ],
            'https://github.github.com/gfm/#example-577' => [
                'input' =>  "[foo][bar][baz]" . "\n" .
                            "" . "\n" .
                            "[baz]: /url",
                'render' => "<p>[foo]<a href=\"/url\">bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-578' => [
                'input' =>  "[foo][bar][baz]" . "\n" .
                            "" . "\n" .
                            "[baz]: /url1" . "\n" .
                            "[bar]: /url2",
                'render' => "<p><a href=\"/url2\">foo</a><a href=\"/url1\">baz</a></p>"
            ],
            'https://github.github.com/gfm/#example-579' => [
                'input' =>  "[foo][bar][baz]" . "\n" .
                            "" . "\n" .
                            "[baz]: /url1" . "\n" .
                            "[foo]: /url2",
                'render' => "<p>[foo]<a href=\"/url1\">bar</a></p>"
            ],
        ];
    }

    public function dataImages(): array
    {
        return [
            'https://github.github.com/gfm/#example-580' => [
                'input' =>  "![foo](/url \"title\")",
                'render' => "<p><img src=\"/url\" alt=\"foo\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-581' => [
                'input' =>  "![foo *bar*]" . "\n" .
                            "" . "\n" .
                            "[foo *bar*]: train.jpg \"train & tracks\"",
                'render' => "<p><img src=\"train.jpg\" alt=\"foo bar\" title=\"train &amp; tracks\" /></p>"
            ],
            'https://github.github.com/gfm/#example-582' => [
                'input' =>  "![foo ![bar](/url)](/url2)",
                'render' => "<p><img src=\"/url2\" alt=\"foo bar\" /></p>"
            ],
            'https://github.github.com/gfm/#example-583' => [
                'input' =>  "![foo [bar](/url)](/url2)",
                'render' => "<p><img src=\"/url2\" alt=\"foo bar\" /></p>"
            ],
            'https://github.github.com/gfm/#example-584' => [
                'input' =>  "![foo *bar*][]" . "\n" .
                            "" . "\n" .
                            "[foo *bar*]: train.jpg \"train & tracks\"",
                'render' => "<p><img src=\"train.jpg\" alt=\"foo bar\" title=\"train &amp; tracks\" /></p>"
            ],
            'https://github.github.com/gfm/#example-585' => [
                'input' =>  "![foo *bar*][foobar]" . "\n" .
                            "" . "\n" .
                            "[FOOBAR]: train.jpg \"train & tracks\"",
                'render' => "<p><img src=\"train.jpg\" alt=\"foo bar\" title=\"train &amp; tracks\" /></p>"
            ],
            'https://github.github.com/gfm/#example-586' => [
                'input' =>  "![foo](train.jpg)",
                'render' => "<p><img src=\"train.jpg\" alt=\"foo\" /></p>"
            ],
            'https://github.github.com/gfm/#example-587' => [
                'input' =>  "My ![foo bar](/path/to/train.jpg  \"title\"   )",
                'render' => "<p>My <img src=\"/path/to/train.jpg\" alt=\"foo bar\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-588' => [
                'input' =>  "![foo](<url>)",
                'render' => "<p><img src=\"url\" alt=\"foo\" /></p>"
            ],
            'https://github.github.com/gfm/#example-589' => [
                'input' =>  "![](/url)",
                'render' => "<p><img src=\"/url\" alt=\"\" /></p>"
            ],
            'https://github.github.com/gfm/#example-590' => [
                'input' =>  "![foo][bar]" . "\n" .
                            "" . "\n" .
                            "[bar]: /url",
                'render' => "<p><img src=\"/url\" alt=\"foo\" /></p>"
            ],
            'https://github.github.com/gfm/#example-591' => [
                'input' =>  "![foo][bar]" . "\n" .
                            "" . "\n" .
                            "[BAR]: /url",
                'render' => "<p><img src=\"/url\" alt=\"foo\" /></p>"
            ],
            'https://github.github.com/gfm/#example-592' => [
                'input' =>  "![foo][]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><img src=\"/url\" alt=\"foo\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-593' => [
                'input' =>  "![*foo* bar][]" . "\n" .
                            "" . "\n" .
                            "[*foo* bar]: /url \"title\"",
                'render' => "<p><img src=\"/url\" alt=\"foo bar\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-594' => [
                'input' =>  "![Foo][]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><img src=\"/url\" alt=\"Foo\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-595' => [
                'input' =>  "![foo] " . "\n" .
                            "[]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><img src=\"/url\" alt=\"foo\" title=\"title\" />" . "\n" .
                            "[]</p>"
            ],
            'https://github.github.com/gfm/#example-596' => [
                'input' =>  "![foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><img src=\"/url\" alt=\"foo\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-597' => [
                'input' =>  "![*foo* bar]" . "\n" .
                            "" . "\n" .
                            "[*foo* bar]: /url \"title\"",
                'render' => "<p><img src=\"/url\" alt=\"foo bar\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-598' => [
                'input' =>  "![[foo]]" . "\n" .
                            "" . "\n" .
                            "[[foo]]: /url \"title\"",
                'render' => "<p>![[foo]]</p>" . "\n" .
                            "<p>[[foo]]: /url &quot;title&quot;</p>"
            ],
            'https://github.github.com/gfm/#example-599' => [
                'input' =>  "![Foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p><img src=\"/url\" alt=\"Foo\" title=\"title\" /></p>"
            ],
            'https://github.github.com/gfm/#example-600' => [
                'input' =>  "!\[foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p>![foo]</p>"
            ],
            'https://github.github.com/gfm/#example-601' => [
                'input' =>  "\![foo]" . "\n" .
                            "" . "\n" .
                            "[foo]: /url \"title\"",
                'render' => "<p>!<a href=\"/url\" title=\"title\">foo</a></p>"
            ],
        ];
    }

    public function dataAutolinks(): array
    {
        return [
            'https://github.github.com/gfm/#example-602' => [
                'input' =>  "<http://foo.bar.baz>",
                'render' => "<p><a href=\"http://foo.bar.baz\">http://foo.bar.baz</a></p>"
            ],
            'https://github.github.com/gfm/#example-603' => [
                'input' =>  "<http://foo.bar.baz/test?q=hello&id=22&boolean>",
                'render' => "<p><a href=\"http://foo.bar.baz/test?q=hello&amp;id=22&amp;boolean\">http://foo.bar.baz/test?q=hello&amp;id=22&amp;boolean</a></p>"
            ],
            'https://github.github.com/gfm/#example-604' => [
                'input' =>  "<irc://foo.bar:2233/baz>",
                'render' => "<p><a href=\"irc://foo.bar:2233/baz\">irc://foo.bar:2233/baz</a></p>"
            ],
            'https://github.github.com/gfm/#example-605' => [
                'input' =>  "<MAILTO:FOO@BAR.BAZ>",
                'render' => "<p><a href=\"MAILTO:FOO@BAR.BAZ\">MAILTO:FOO@BAR.BAZ</a></p>"
            ],
            'https://github.github.com/gfm/#example-606' => [
                'input' =>  "<a+b+c:d>",
                'render' => "<p><a href=\"a+b+c:d\">a+b+c:d</a></p>"
            ],
            'https://github.github.com/gfm/#example-607' => [
                'input' =>  "<made-up-scheme://foo,bar>",
                'render' => "<p><a href=\"made-up-scheme://foo,bar\">made-up-scheme://foo,bar</a></p>"
            ],
            'https://github.github.com/gfm/#example-608' => [
                'input' =>  "<http://../>",
                'render' => "<p><a href=\"http://../\">http://../</a></p>"
            ],
            'https://github.github.com/gfm/#example-609' => [
                'input' =>  "<localhost:5001/foo>",
                'render' => "<p><a href=\"localhost:5001/foo\">localhost:5001/foo</a></p>"
            ],
            'https://github.github.com/gfm/#example-610' => [
                'input' =>  "<http://foo.bar/baz bim>",
                'render' => "<p>&lt;http://foo.bar/baz bim&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-611' => [
                'input' =>  "<http://example.com/\[\>",
                'render' => "<p><a href=\"http://example.com/%5C%5B%5C\">http://example.com/\[\</a></p>"
            ],
            'https://github.github.com/gfm/#example-612' => [
                'input' =>  "<foo@bar.example.com>",
                'render' => "<p><a href=\"mailto:foo@bar.example.com\">foo@bar.example.com</a></p>"
            ],
            'https://github.github.com/gfm/#example-613' => [
                'input' =>  "<foo+special@Bar.baz-bar0.com>",
                'render' => "<p><a href=\"mailto:foo+special@Bar.baz-bar0.com\">foo+special@Bar.baz-bar0.com</a></p>"
            ],
            'https://github.github.com/gfm/#example-614' => [
                'input' =>  "<foo\+@bar.example.com>",
                'render' => "<p>&lt;foo+@bar.example.com&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-615' => [
                'input' =>  "<>",
                'render' => "<p>&lt;&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-616' => [
                'input' =>  "< http://foo.bar >",
                'render' => "<p>&lt; http://foo.bar &gt;</p>"
            ],
            'https://github.github.com/gfm/#example-617' => [
                'input' =>  "<m:abc>",
                'render' => "<p>&lt;m:abc&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-618' => [
                'input' =>  "<foo.bar.baz>",
                'render' => "<p>&lt;foo.bar.baz&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-619' => [
                'input' =>  "http://example.com",
                'render' => "<p>http://example.com</p>"
            ],
            'https://github.github.com/gfm/#example-620' => [
                'input' =>  "foo@bar.example.com",
                'render' => "<p>foo@bar.example.com</p>"
            ],
            'https://github.github.com/gfm/#example-621' => [
                'input' =>  "www.commonmark.org",
                'render' => "<p><a href=\"http://www.commonmark.org\">www.commonmark.org</a></p>"
            ],
            'https://github.github.com/gfm/#example-622' => [
                'input' =>  "Visit www.commonmark.org/help for more information.",
                'render' => "<p>Visit <a href=\"http://www.commonmark.org/help\">www.commonmark.org/help</a> for more information.</p>"
            ],
            'https://github.github.com/gfm/#example-623' => [
                'input' =>  "Visit www.commonmark.org." . "\n" .
                            "" . "\n" .
                            "Visit www.commonmark.org/a.b.",
                'render' => "<p>Visit <a href=\"http://www.commonmark.org\">www.commonmark.org</a>.</p>" . "\n" .
                            "<p>Visit <a href=\"http://www.commonmark.org/a.b\">www.commonmark.org/a.b</a>.</p>"
            ],
            'https://github.github.com/gfm/#example-624' => [
                'input' =>  "www.google.com/search?q=Markup+(business)" . "\n" .
                            "" . "\n" .
                            "www.google.com/search?q=Markup+(business)))" . "\n" .
                            "" . "\n" .
                            "(www.google.com/search?q=Markup+(business))" . "\n" .
                            "" . "\n" .
                            "(www.google.com/search?q=Markup+(business)",
                'render' => "<p><a href=\"http://www.google.com/search?q=Markup+(business)\">www.google.com/search?q=Markup+(business)</a></p>" . "\n" .
                            "<p><a href=\"http://www.google.com/search?q=Markup+(business)\">www.google.com/search?q=Markup+(business)</a>))</p>" . "\n" .
                            "<p>(<a href=\"http://www.google.com/search?q=Markup+(business)\">www.google.com/search?q=Markup+(business)</a>)</p>" . "\n" .
                            "<p>(<a href=\"http://www.google.com/search?q=Markup+(business)\">www.google.com/search?q=Markup+(business)</a></p>"
            ],
            'https://github.github.com/gfm/#example-625' => [
                'input' =>  "www.google.com/search?q=(business))+ok",
                'render' => "<p><a href=\"http://www.google.com/search?q=(business))+ok\">www.google.com/search?q=(business))+ok</a></p>"
            ],
            'https://github.github.com/gfm/#example-626' => [
                'input' =>  "www.google.com/search?q=commonmark&hl=en" . "\n" .
                            "" . "\n" .
                            "www.google.com/search?q=commonmark&hl;",
                'render' => "<p><a href=\"http://www.google.com/search?q=commonmark&amp;hl=en\">www.google.com/search?q=commonmark&amp;hl=en</a></p>" . "\n" .
                            "<p><a href=\"http://www.google.com/search?q=commonmark\">www.google.com/search?q=commonmark</a>&amp;hl;</p>"
            ],
            'https://github.github.com/gfm/#example-627' => [
                'input' =>  "www.commonmark.org/he<lp",
                'render' => "<p><a href=\"http://www.commonmark.org/he\">www.commonmark.org/he</a>&lt;lp</p>"
            ],
            'https://github.github.com/gfm/#example-628' => [
                'input' =>  "http://commonmark.org" . "\n" .
                            "" . "\n" .
                            "(Visit https://encrypted.google.com/search?q=Markup+(business))",
                'render' => "<p><a href=\"http://commonmark.org\">http://commonmark.org</a></p>" . "\n" .
                            "<p>(Visit <a href=\"https://encrypted.google.com/search?q=Markup+(business)\">https://encrypted.google.com/search?q=Markup+(business)</a>)</p>"
            ],
            'https://github.github.com/gfm/#example-629' => [
                'input' =>  "foo@bar.baz",
                'render' => "<p><a href=\"mailto:foo@bar.baz\">foo@bar.baz</a></p>"
            ],
            'https://github.github.com/gfm/#example-630' => [
                'input' =>  "hello@mail+xyz.example isn't valid, but hello+xyz@mail.example is.",
                'render' => "<p>hello@mail+xyz.example isn't valid, but <a href=\"mailto:hello+xyz@mail.example\">hello+xyz@mail.example</a> is.</p>"
            ],
            'https://github.github.com/gfm/#example-631' => [
                'input' =>  "a.b-c_d@a.b" . "\n" .
                            "" . "\n" .
                            "a.b-c_d@a.b." . "\n" .
                            "" . "\n" .
                            "a.b-c_d@a.b-" . "\n" .
                            "" . "\n" .
                            "a.b-c_d@a.b_",
                'render' => "<p><a href=\"mailto:a.b-c_d@a.b\">a.b-c_d@a.b</a></p>" . "\n" .
                            "<p><a href=\"mailto:a.b-c_d@a.b\">a.b-c_d@a.b</a>.</p>" . "\n" .
                            "<p>a.b-c_d@a.b-</p>" . "\n" .
                            "<p>a.b-c_d@a.b_</p>"
            ],
        ];
    }

    public function dataRawHTML(): array
    {
        return [
            'https://github.github.com/gfm/#example-632' => [
                'input' =>  "<a><bab><c2c>",
                'render' => "<p><a><bab><c2c></p>"
            ],
            'https://github.github.com/gfm/#example-633' => [
                'input' =>  "<a/><b2/>",
                'render' => "<p><a/><b2/></p>"
            ],
            'https://github.github.com/gfm/#example-634' => [
                'input' =>  "<a  /><b2" . "\n" .
                            "data=\"foo\" >",
                'render' => "<p><a  /><b2" . "\n" .
                            "data=\"foo\" ></p>"
            ],
            'https://github.github.com/gfm/#example-635' => [
                'input' =>  "<a foo=\"bar\" bam = 'baz <em>\"</em>'" . "\n" .
                            "_boolean zoop:33=zoop:33 />",
                'render' => "<p><a foo=\"bar\" bam = 'baz <em>\"</em>'" . "\n" .
                            "_boolean zoop:33=zoop:33 /></p>"
            ],
            'https://github.github.com/gfm/#example-636' => [
                'input' =>  "Foo <responsive-image src=\"foo.jpg\" />",
                'render' => "<p>Foo <responsive-image src=\"foo.jpg\" /></p>"
            ],
            'https://github.github.com/gfm/#example-637' => [
                'input' =>  "<33> <__>",
                'render' => "<p>&lt;33&gt; &lt;__&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-638' => [
                'input' =>  "<a h*#ref=\"hi\">",
                'render' => "<p>&lt;a h*#ref=&quot;hi&quot;&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-639' => [
                'input' =>  "<a href=\"hi'> <a href=hi'>",
                'render' => "<p>&lt;a href=&quot;hi'&gt; &lt;a href=hi'&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-640' => [
                'input' =>  "< a><" . "\n" .
                            "foo><bar/ >" . "\n" .
                            "<foo bar=baz" . "\n" .
                            "bim!bop />",
                'render' => "<p>&lt; a&gt;&lt;" . "\n" .
                            "foo&gt;&lt;bar/ &gt;" . "\n" .
                            "&lt;foo bar=baz" . "\n" .
                            "bim!bop /&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-641' => [
                'input' =>  "<a href='bar'title=title>",
                'render' => "<p>&lt;a href='bar'title=title&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-642' => [
                'input' =>  "</a></foo >",
                'render' => "<p></a></foo ></p>"
            ],
            'https://github.github.com/gfm/#example-643' => [
                'input' =>  "</a href=\"foo\">",
                'render' => "<p>&lt;/a href=&quot;foo&quot;&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-644' => [
                'input' =>  "foo <!-- this is a" . "\n" .
                            "comment - with hyphen -->",
                'render' => "<p>foo <!-- this is a" . "\n" .
                            "comment - with hyphen --></p>"
            ],
            'https://github.github.com/gfm/#example-645' => [
                'input' =>  "foo <!-- not a comment -- two hyphens -->",
                'render' => "<p>foo &lt;!-- not a comment -- two hyphens --&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-646' => [
                'input' =>  "foo <!--> foo -->" . "\n" .
                            "" . "\n" .
                            "foo <!-- foo--->",
                'render' => "<p>foo &lt;!--&gt; foo --&gt;</p>" . "\n" .
                            "<p>foo &lt;!-- foo---&gt;</p>"
            ],
            'https://github.github.com/gfm/#example-647' => [
                'input' =>  "foo <?php echo \$a; ?>",
                'render' => "<p>foo <?php echo \$a; ?></p>"
            ],
            'https://github.github.com/gfm/#example-648' => [
                'input' =>  "foo <!ELEMENT br EMPTY>",
                'render' => "<p>foo <!ELEMENT br EMPTY></p>"
            ],
            'https://github.github.com/gfm/#example-649' => [
                'input' =>  "foo <![CDATA[>&<]]>",
                'render' => "<p>foo <![CDATA[>&<]]></p>"
            ],
            'https://github.github.com/gfm/#example-650' => [
                'input' =>  "foo <a href=\"&ouml;\">",
                'render' => "<p>foo <a href=\"&ouml;\"></p>"
            ],
            'https://github.github.com/gfm/#example-651' => [
                'input' =>  "foo <a href=\"\*\">",
                'render' => "<p>foo <a href=\"\*\"></p>"
            ],
            'https://github.github.com/gfm/#example-652' => [
                'input' =>  "<a href=\"\\\"\">",
                'render' => "<p>&lt;a href=&quot;&quot;&quot;&gt;</p>"
            ],
        ];
    }

    public function dataDisallowedRawHTML (): array
    {
        return [
            'https://github.github.com/gfm/#example-653' => [
                'input' =>  "<strong> <title> <style> <em>" . "\n" .
                            "" . "\n" .
                            "<blockquote>" . "\n" .
                            "  <xmp> is disallowed.  <XMP> is also disallowed." . "\n" .
                            "</blockquote>",
                'render' => "<p><strong> &lt;title> &lt;style> <em></p>" . "\n" .
                            "<blockquote>" . "\n" .
                            "  &lt;xmp> is disallowed.  &lt;XMP> is also disallowed." . "\n" .
                            "</blockquote>"
            ],
        ];
    }

    public function dataHardLineBreaks(): array
    {
        return [
            'https://github.github.com/gfm/#example-654' => [
                'input' =>  "foo  " . "\n" .
                            "baz",
                'render' => "<p>foo<br />" . "\n" .
                            "baz</p>"
            ],
            'https://github.github.com/gfm/#example-655' => [
                'input' =>  "foo\\" . "\n" .
                            "baz",
                'render' => "<p>foo<br />" . "\n" .
                            "baz</p>"
            ],
            'https://github.github.com/gfm/#example-656' => [
                'input' =>  "foo       " . "\n" .
                            "baz",
                'render' => "<p>foo<br />" . "\n" .
                            "baz</p>"
            ],
            'https://github.github.com/gfm/#example-657' => [
                'input' =>  "foo  " . "\n" .
                            "     bar",
                'render' => "<p>foo<br />" . "\n" .
                            "bar</p>"
            ],
            'https://github.github.com/gfm/#example-658' => [
                'input' =>  "foo\\" . "\n" .
                            "     bar",
                'render' => "<p>foo<br />" . "\n" .
                            "bar</p>"
            ],
            'https://github.github.com/gfm/#example-659' => [
                'input' =>  "*foo  " . "\n" .
                            "bar*",
                'render' => "<p><em>foo<br />" . "\n" .
                            "bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-660' => [
                'input' =>  "*foo\\" . "\n" .
                            "bar*",
                'render' => "<p><em>foo<br />" . "\n" .
                            "bar</em></p>"
            ],
            'https://github.github.com/gfm/#example-661' => [
                'input' =>  "`code  " . "\n" .
                            "span`",
                'render' => "<p><code>code   span</code></p>"
            ],
            'https://github.github.com/gfm/#example-662' => [
                'input' =>  "`code\\" . "\n" .
                            "span`",
                'render' => "<p><code>code\\ span</code></p>"
            ],
            'https://github.github.com/gfm/#example-663' => [
                'input' =>  "<a href=\"foo  " . "\n" .
                            "bar\">",
                'render' => "<p><a href=\"foo  " . "\n" .
                            "bar\"></p>"
            ],
            'https://github.github.com/gfm/#example-664' => [
                'input' =>  "<a href=\"foo\\" . "\n" .
                            "bar\">",
                'render' => "<p><a href=\"foo\\" . "\n" .
                            "bar\"></p>"
            ],
            'https://github.github.com/gfm/#example-665' => [
                'input' =>  "foo\\",
                'render' => "<p>foo\\</p>"
            ],
            'https://github.github.com/gfm/#example-666' => [
                'input' =>  "foo  ",
                'render' => "<p>foo</p>"
            ],
            'https://github.github.com/gfm/#example-667' => [
                'input' =>  "### foo\\",
                'render' => "<h3>foo\\</h3>"
            ],
            'https://github.github.com/gfm/#example-668' => [
                'input' =>  "### foo  ",
                'render' => "<h3>foo</h3>"
            ],
        ];
    }

    public function dataSoftLineBreaks(): array
    {
        return [
            'https://github.github.com/gfm/#example-669' => [
                'input' =>  "foo" . "\n" .
                            "baz",
                'render' => "<p>foo" . "\n" .
                            "baz</p>"
            ],
            'https://github.github.com/gfm/#example-670' => [
                'input' =>  "foo " . "\n" .
                            " baz",
                'render' => "<p>foo" . "\n" .
                            "baz</p>"
            ],
        ];
    }

    public function dataTextualContent(): array
    {
        return [
            'https://github.github.com/gfm/#example-671' => [
                'input' =>  "hello $.;'there",
                'render' => "<p>hello $.;'there</p>"
            ],
            'https://github.github.com/gfm/#example-672' => [
                'input' =>  "Foo χρῆν",
                'render' => "<p>Foo χρῆν</p>"
            ],
            'https://github.github.com/gfm/#example-673' => [
                'input' =>  "Multiple     spaces",
                'render' => "<p>Multiple     spaces</p>"
            ],
        ];
    }
}
