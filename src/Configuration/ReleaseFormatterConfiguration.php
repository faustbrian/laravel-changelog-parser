<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Configuration;

final class ReleaseFormatterConfiguration
{
    public function __construct(
        public readonly bool $includeTagReferences = false,
    ) {
        //
    }
}
