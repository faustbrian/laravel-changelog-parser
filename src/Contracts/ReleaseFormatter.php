<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Contracts;

use PreemStudio\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use PreemStudio\ChangelogParser\Data\Release;

interface ReleaseFormatter
{
    public function format(Release $release, ?ReleaseFormatterConfiguration $configuration): string;
}
