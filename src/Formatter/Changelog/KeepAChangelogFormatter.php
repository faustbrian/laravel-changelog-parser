<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Formatter\Changelog;

use BaseCodeOy\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Contracts\ChangelogFormatter;
use BaseCodeOy\ChangelogParser\Data\Changelog;
use BaseCodeOy\ChangelogParser\Data\Release;
use BaseCodeOy\ChangelogParser\Enum\SectionEnum;
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
