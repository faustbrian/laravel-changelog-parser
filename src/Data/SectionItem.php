<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use PreemStudio\ChangelogParser\Support\MarkdownConverter;
use Spatie\LaravelData\Data;

final class SectionItem extends Data
{
    public function __construct(public readonly string $content)
    {
        //
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function toHtml(): string
    {
        return MarkdownConverter::toString($this->content);
    }
}
