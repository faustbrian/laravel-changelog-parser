<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Formatter\Changelog;

use Illuminate\Support\Facades\View;
use BombenProdukt\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BombenProdukt\ChangelogParser\Contracts\ChangelogFormatter;
use BombenProdukt\ChangelogParser\Data\Changelog;

final class CommonChangelogFormatter implements ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration = null): string
    {
        return View::make('changelog-parser::common-changelog', [
            'configuration' => $configuration ?? new ChangelogFormatterConfiguration(),
            'releases' => $changelog->getReleases(),
        ])->render();
    }
}
