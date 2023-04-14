<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer\Node;

use PreemStudio\ChangelogParser\Contracts\Node;

abstract class AbstractNode implements Node
{
    public function __construct(
        private readonly int $lineNumber,
        private readonly string $text,
    ) {
        //
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getLineNumber(): int
    {
        return $this->lineNumber;
    }

    public function isHeading(): bool
    {
        if ($this->isChangeTypeHeading()) {
            return true;
        }

        if ($this->isDocumentHeading()) {
            return true;
        }

        if ($this->isReleaseHeading()) {
            return true;
        }

        return false;
    }

    public function isText(): bool
    {
        if ($this->isFlag()) {
            return false;
        }

        if ($this->isHeading()) {
            return false;
        }

        if ($this->isListItem()) {
            return false;
        }

        if ($this->isReference()) {
            return false;
        }

        return true;
    }

    public function isChangeTypeHeading(): bool
    {
        return $this instanceof ChangeTypeHeading;
    }

    public function isDocumentHeading(): bool
    {
        return $this instanceof DocumentHeading;
    }

    public function isFlag(): bool
    {
        return $this instanceof Flag;
    }

    public function isLineBreak(): bool
    {
        return $this instanceof LineBreak;
    }

    public function isLink(): bool
    {
        return $this instanceof Link;
    }

    public function isListItem(): bool
    {
        return $this instanceof ListItem;
    }

    public function isParagraph(): bool
    {
        return $this instanceof Paragraph;
    }

    public function isReference(): bool
    {
        return $this instanceof Reference;
    }

    public function isReleaseHeading(): bool
    {
        return $this instanceof ReleaseHeading;
    }

    public function isThematicBreak(): bool
    {
        return $this instanceof ThematicBreak;
    }
}
