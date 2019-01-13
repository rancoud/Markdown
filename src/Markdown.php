<?php

declare(strict_types=1);

namespace Rancoud\Markdown;

use Rancoud\Markdown\Block\BlankLine;
use Rancoud\Markdown\Block\Block;
use Rancoud\Markdown\Block\BlockQuote;
use Rancoud\Markdown\Block\Heading;
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
    protected $blocks = [
        0   => BlankLine::class,
        10  => Heading::class,
        20  => ThematicBreak::class,
        30  => BlockQuote::class,
        999 => Paragraph::class
    ];

    /** @var Inline[] */
    protected $inlines = [
        0 => Emphasis::class
    ];

    //endregion

    //region Outline content

    /** @var Block[] */
    protected $document = [];

    //endregion

    //region Treatement

    /** @var string[] */
    protected $lines = [];

    protected $heap = [];

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
    
    //endregion

    /**
     * @param string $content
     */
    protected function getLines(string $content): void
    {
        $this->lines = \preg_split('/\R/', $content);
        $countLines = \count($this->lines);
        if ($countLines === 0) {
            return;
        }

        for ($i = 0; $i < $countLines; ++$i) {
            if (\trim($this->lines[$i]) === '') {
                \array_shift($this->lines);
                --$i;
                --$countLines;
            } else {
                break;
            }
        }

        $countLines = \count($this->lines);
        if ($countLines === 0) {
            return;
        }

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
        $className = get_class($block);
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
                if (get_class($block) === BlankLine::class && !$this->isEmptyHeap()) {
                    $this->popHeap();
                }
            }

            if ($blockLastHeap !== null && $className == get_class($blockLastHeap) && $blockLastHeap->getParent() === $block) {
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
        /*foreach ($this->blocks as $block) {
            $res = $block::isMe($line);
            if ($res !== null) {
                $this->manageHeap($res, $line);
                if (!$res::isLeaf()) {
                    $this->scanLine($res->getLine());
                }
                break;
            }
        }*/

        if ($blockLastHeap !== null && $className == get_class($blockLastHeap)) {
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
            $res = $block::isMe($line);
            if ($res !== null) {
                return $res;
            }
        }
        
        return null;
    }

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
        $element = array_pop($this->heap);
        if ($element === false) {
            return;
        }
        if ($element->getParent() !== null) {
            end($this->heap)->appendBlock($element);
        } else {
            $this->document[] = $element;
        }
    }

    /**
     * @return Block|null
     */
    protected function lastHeap(): ?Block
    {
        $block = end($this->heap);

        return ($block === false) ? null : $block;
    }

    /**
     * @return bool
     */
    protected function isEmptyHeap(): bool
    {
        return count($this->heap) === 0;
    }
    
    protected function getSameBlockLevelInHeap($block, $parent)
    {
        $p = ($parent === null) ? null : get_class($parent);
        foreach ($this->heap as $bl) {
            if (get_class($bl) == get_class($block)) {
                $pp = ($bl->getParent() === null) ? null : get_class($bl->getParent());
                if ($p === $pp) {
                    return $bl;
                }
            }
        }

        return null;
    }

    protected function popSameBlockLevelInHeap($block, $parent)
    {
        $p = ($parent === null) ? null : get_class($parent);
        $limit = null;
        foreach ($this->heap as $bl) {
            if (get_class($bl) == get_class($block)) {
                $pp = ($bl->getParent() === null) ? null : get_class($bl->getParent());
                if ($p === $pp) {
                    $limit = $bl;
                    break;
                }
            }
        }

        while (count($this->heap) > 0 || $limit != end($this->heap)) {
            $element = array_pop($this->heap);
            if ($element->getParent() !== null) {
                end($this->heap)->appendBlock($element);
            } else {
                $this->document[] = $element;
            }
        }

        return end($this->heap);
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
            $content[] = $block->render($this);
        }

        return \implode("\r\n", $content);
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
