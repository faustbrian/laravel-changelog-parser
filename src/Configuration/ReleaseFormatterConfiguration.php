<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Configuration;

final class ReleaseFormatterConfiguration
{
    public function __construct(
        public readonly bool $includeTagReferences = false,
    ) {
        //
    }
}
