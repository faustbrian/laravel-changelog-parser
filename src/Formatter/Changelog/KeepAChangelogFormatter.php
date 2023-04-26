<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Formatter\Changelog;

use BombenProdukt\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BombenProdukt\ChangelogParser\Contracts\ChangelogFormatter;
use BombenProdukt\ChangelogParser\Data\Changelog;
use BombenProdukt\ChangelogParser\Data\Release;
use BombenProdukt\ChangelogParser\Enum\SectionEnum;
use Illuminate\Support\Facades\View;

final class KeepAChangelogFormatter implements ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration = null): string
    {
        return View::make('changelog-parser::keep-a-changelog', [
            'configuration' => $configuration ?? new ChangelogFormatterConfiguration(),
            'releases' => $changelog->getReleases()
                // Making sure that the 'Unreleased' section is always at the top.
                ->sortBy(fn (Release $release) => $release->getVersion() !== SectionEnum::UNRELEASED->value),
        ])->render();
    }
}
