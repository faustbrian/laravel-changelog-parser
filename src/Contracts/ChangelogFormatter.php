<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Contracts;

use PreemStudio\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use PreemStudio\ChangelogParser\Data\Changelog;

interface ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration): string;
}
