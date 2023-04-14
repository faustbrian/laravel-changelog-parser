<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Actions\SortReleaseSections;
use PreemStudio\ChangelogParser\Contracts\Formatter;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Enum\SectionEnum;

/**
 * @see https://keepachangelog.com/
 */
final class KeepAChangelogFormatter implements Formatter
{
    public function format(Changelog $changelog): string
    {
        return View::make('changelog-parser::keep-a-changelog', [
            // Making sure that the 'Unreleased' section is always at the top.
            'releases' => $changelog->releases
                ->map(fn (Release $release): Release => SortReleaseSections::execute($release))
                ->sortBy(fn (Release $release) => $release->version !== SectionEnum::UNRELEASED->value),
        ])->render();
    }
}
