<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Contracts;

use BaseCodeOy\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Data\Changelog;

interface ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration): string;
}
