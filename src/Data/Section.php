<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Spatie\LaravelData\Data;

final class Section extends Data
{
    use Concerns\WithDescription;

    public function __construct(
        public readonly string $type,
        public readonly array $entries,
        public array $description = [],
    ) {
        //
    }
}
