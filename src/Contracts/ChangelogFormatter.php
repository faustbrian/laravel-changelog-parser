<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Contracts;

use BombenProdukt\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BombenProdukt\ChangelogParser\Data\Changelog;

interface ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration): string;
}
