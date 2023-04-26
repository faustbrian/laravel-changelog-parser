<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Contracts;

use BombenProdukt\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use BombenProdukt\ChangelogParser\Data\Release;

interface ReleaseFormatter
{
    public function format(Release $release, ?ReleaseFormatterConfiguration $configuration): string;
}
