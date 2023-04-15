<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter\Changelog;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Actions\SortReleaseSections;
use PreemStudio\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use PreemStudio\ChangelogParser\Contracts\ChangelogFormatter;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Data\Release;

final class CommonChangelogFormatter implements ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration = null): string
    {
        return View::make('changelog-parser::common-changelog', [
            'configuration' => $configuration ?? new ChangelogFormatterConfiguration(),
            'releases' => $changelog->getReleases()->map(fn (Release $release): Release => SortReleaseSections::execute($release)),
        ])->render();
    }
}
