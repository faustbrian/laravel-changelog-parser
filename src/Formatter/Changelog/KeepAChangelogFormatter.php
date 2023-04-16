<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter\Changelog;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use PreemStudio\ChangelogParser\Contracts\ChangelogFormatter;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Enum\SectionEnum;

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
