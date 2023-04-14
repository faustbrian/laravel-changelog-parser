<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter\Changelog;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Actions\SortReleaseSections;
use PreemStudio\ChangelogParser\Contracts\ChangelogFormatter;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Enum\SectionEnum;

final class KeepAChangelogFormatter implements ChangelogFormatter
{
    public function format(Changelog $changelog): string
    {
        return View::make('changelog-parser::keep-a-changelog', [
            'releases' => $changelog->releases
                ->map(fn (Release $release): Release => SortReleaseSections::execute($release))
                // Making sure that the 'Unreleased' section is always at the top.
                ->sortBy(fn (Release $release) => $release->version !== SectionEnum::UNRELEASED->value),
        ])->render();
    }
}
