<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Configuration;

final class ChangelogFormatterConfiguration
{
    public function __construct(
        public readonly bool $includeHeader = true,
        public readonly bool $includeTagReferences = true,
    ) {
        //
    }
}
