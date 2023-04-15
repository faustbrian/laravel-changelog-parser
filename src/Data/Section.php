<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Spatie\LaravelData\Data;

final class Section extends Data
{
    public function __construct(
        private readonly string $type,
        private readonly string $content,
        private readonly ?string $description = null,
    ) {
        //
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getItems(): array
    {
        return \array_map(
            fn (string $item) => \trim(\mb_substr($item, 1)),
            \array_filter(
                \explode("\n", $this->content),
                fn (string $item) => \str_starts_with($item, '-'),
            ),
        );
    }
}
