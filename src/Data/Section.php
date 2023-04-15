<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Spatie\LaravelData\Data;

final class Section extends Data
{
    public function __construct(
        public readonly string $type,
        public readonly string $content,
        public readonly ?string $description = null,
    ) {
        //
    }
}
