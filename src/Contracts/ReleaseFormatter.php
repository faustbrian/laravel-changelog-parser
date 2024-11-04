<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Contracts;

use BaseCodeOy\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Data\Release;

interface ReleaseFormatter
{
    public function format(Release $release, ?ReleaseFormatterConfiguration $configuration): string;
}
