<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Data;

final readonly class SectionItem
{
    public function __construct(
        private string $html,
        private string $plain,
    ) {}

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->plain;
    }

    public function toHtml(): string
    {
        return $this->html;
    }
}
