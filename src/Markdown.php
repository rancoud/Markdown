<?php

declare(strict_types=1);

namespace Rancoud\Markdown;

use Rancoud\Markdown\Block\BlankLine;
use Rancoud\Markdown\Block\Block;
use Rancoud\Markdown\Block\Blockquote;
use Rancoud\Markdown\Block\FencedCode;
use Rancoud\Markdown\Block\Heading;
use Rancoud\Markdown\Block\Html;
use Rancoud\Markdown\Block\IndentedCode;
use Rancoud\Markdown\Block\LinkReferenceDefinition;
use Rancoud\Markdown\Block\Paragraph;
use Rancoud\Markdown\Block\ThematicBreak;
use Rancoud\Markdown\Inline\Emphasis;
use Rancoud\Markdown\Inline\Inline;

/**
 * Class Markdown.
 */
class Markdown
{
    //region Parsing Blocks and Inlines

    /** @var Block[] */
    protected array $blocks = [
        0   => BlankLine::class,
        10  => Heading::class,
        20  => ThematicBreak::class,
        30  => Blockquote::class,
        40  => IndentedCode::class,
        50  => FencedCode::class,
        60  => Html::class,
        70  => LinkReferenceDefinition::class,
        999 => Paragraph::class
    ];

    /** @var Inline[] */
    protected array $inlines = [
        0 => Emphasis::class
    ];

    //endregion

    //region Outline content

    /** @var Block[] */
    protected array $document = [];

    //endregion

    //region Treatement

    /** @var string[] */
    protected array $lines = [];

    protected array $heap = [];

    //endregion

    //region Public methods (render)

    /**
     * @param string $content
     *
     * @return string
     */
    public function render(string $content): string
    {
        $this->heap = $this->document = [];

        $this->getLines($content);
        $this->scanLines();

        return $this->renderDocument();
    }

    public function addInlines(string ...$inlines): void
    {
        $inlines[] = $inlines;
    }

    public function removeInlines(string ...$inlines): void
    {
        $inlines[] = $inlines;
    }

    public function addBlocks(string ...$blocks): void
    {
        $blocks[] = $blocks;
    }

    public function removeBlocks(string ...$blocks): void
    {
        $blocks[] = $blocks;
    }

    //endregion

    // region Scan content

    /**
     * @param string $content
     */
    protected function getLines(string $content): void
    {
        // split lines into array
        $this->lines = \preg_split('/\R/', $content);
        $countLines = \count($this->lines);
        if ($countLines === 0) {
            return;
        }

        // remove top empty lines
        for ($i = 0; $i < $countLines; ++$i) {
            if (\trim($this->lines[$i]) === '') {
                \array_shift($this->lines);
                --$i;
                --$countLines;
            } else {
                break;
            }
        }

        // if empty stop process
        $countLines = \count($this->lines);
        if ($countLines === 0) {
            return;
        }

        // remove bottom empty lines
        for ($i = $countLines - 1; $i > 0; --$i) {
            if (\trim($this->lines[$i]) === '') {
                \array_pop($this->lines);
            } else {
                break;
            }
        }
    }

    protected function scanLines(): void
    {
        foreach ($this->lines as $line) {
            $this->scanLine($line);
        }

        while (\count($this->heap) > 0) {
            $this->popHeap();
        }
    }

    /**
     * @param string     $line
     * @param Block|null $parent
     */
    protected function scanLine(string $line, ?Block $parent = null): void
    {
        /** @var ?Block $block */
        $block = $this->findType($line);
        if ($block === null) {
            return;
        }

        $name = $block->getName();
        $blockLastHeap = $this->lastHeap();

        if ($parent !== null) {
            $block->setParent($parent);
        }

        if (!$this->isEmptyHeap()) {
            $oldBlock = $this->getSameBlockLevelInHeap($block, $parent);
            if ($oldBlock && $block->isContainer()) {
                $this->scanLine($block->getLine(), $oldBlock);

                return;
            }

            if ($block->canClose($blockLastHeap)) {
                $this->popHeap();
                if ($name === 'BlankLine' && !$this->isEmptyHeap()) {
                    $this->popHeap();
                }
            }

            if ($name === $blockLastHeap->getName() && $blockLastHeap->getParent() === $block) {
                if ($blockLastHeap->canAppend()) {
                    $this->scanLine($block->getLine(), $this->getSameBlockLevelInHeap($block, $parent));
                } else {
                    $this->popSameBlockLevelInHeap($block, $parent);
                }
            }
        }

        if ($block->isContainer()) {
            $this->pushHeap($block);
            $this->scanLine($block->getLine(), $block);

            return;
        }

        if ($blockLastHeap !== null && $name === $blockLastHeap->getName()) {
            $blockLastHeap->appendContent($line);

            return;
        }

        $this->pushHeap($block);
    }

    /**
     * @param string $line
     *
     * @return Block|null
     */
    protected function findType(string $line): ?Block
    {
        foreach ($this->blocks as $block) {
            $blockFound = $block::getBlock($line);
            if ($blockFound !== null) {
                return $blockFound;
            }
        }

        return null;
    }

    // endregion

    //region Heap Management

    /**
     * @param Block $element
     */
    protected function pushHeap(Block $element): void
    {
        $this->heap[] = $element;
    }

    protected function popHeap(): void
    {
        /** @var Block $element */
        $element = \array_pop($this->heap);
        if ($element === false) {
            return;
        }

        if ($element->getParent() !== null) {
            $ret = \end($this->heap);
            if ($ret !== false) {
                $ret->appendBlock($element);
            }
        } else {
            $this->document[] = $element;
        }
    }

    /**
     * @return Block|null
     */
    protected function lastHeap(): ?Block
    {
        $block = \end($this->heap);

        return ($block === false) ? null : $block;
    }

    /**
     * @return bool
     */
    protected function isEmptyHeap(): bool
    {
        return \count($this->heap) === 0;
    }

    /**
     * @param Block      $block
     * @param Block|null $parent
     *
     * @return mixed|null
     */
    protected function getSameBlockLevelInHeap(Block $block, ?Block $parent)
    {
        $p = ($parent === null) ? null : $parent->getName();
        foreach ($this->heap as $bl) {
            if ($bl->getName() === $block->getName()) {
                $pp = ($bl->getParent() === null) ? null : $bl->getParent()->getName();
                if ($p === $pp) {
                    return $bl;
                }
            }
        }

        return null;
    }

    /**
     * @param $block
     * @param $parent
     *
     * @return mixed
     */
    protected function popSameBlockLevelInHeap(Block $block, ?Block $parent)
    {
        $p = ($parent === null) ? null : $parent->getName();
        $limit = null;
        foreach ($this->heap as $bl) {
            if ($bl->getName() === $block->getName()) {
                $pp = ($bl->getParent() === null) ? null : $bl->getParent()->getName();
                if ($p === $pp) {
                    $limit = $bl;
                    break;
                }
            }
        }

        while (\count($this->heap) > 0 || $limit !== \end($this->heap)) {
            $element = \array_pop($this->heap);
            if ($element->getParent() !== null) {
                \end($this->heap)->appendBlock($element);
            } else {
                $this->document[] = $element;
            }
        }

        return \end($this->heap);
    }

    //endregion

    //region Rendering

    /**
     * @return string
     */
    protected function renderDocument(): string
    {
        $content = [];

        foreach ($this->document as $block) {
            if ($block->getName() === 'BlankLine') {
                continue;
            }

            $content[] = $block->render($this);
        }

        return \implode("\n", $content);
    }

    /**
     * @param string $content
     *
     * @return string
     */
    public function renderInline(string $content): string
    {
        foreach ($this->inlines as $inline) {
            $content = $inline::render($content);
        }

        return $content;
    }

    //endregion
}
