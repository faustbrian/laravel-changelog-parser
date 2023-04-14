<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Contracts;

interface Node
{
    public function getText(): string;

    public function getLineNumber(): int;

    public function isHeading(): bool;

    public function isText(): bool;

    public function isChangeTypeHeading(): bool;

    public function isDocumentHeading(): bool;

    public function isFlag(): bool;

    public function isLineBreak(): bool;

    public function isLink(): bool;

    public function isListItem(): bool;

    public function isParagraph(): bool;

    public function isReference(): bool;

    public function isReleaseHeading(): bool;

    public function isThematicBreak(): bool;
}
