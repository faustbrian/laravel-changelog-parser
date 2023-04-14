<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Actions\SortReleaseSections;
use PreemStudio\ChangelogParser\Contracts\Formatter;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Data\Release;

/**
 * @see https://common-changelog.org/
 */
final class CommonChangelogFormatter implements Formatter
{
    public function format(Changelog $changelog): string
    {
        return View::make('changelog-parser::common-changelog', [
            'releases' => $changelog->releases->map(fn (Release $release): Release => SortReleaseSections::execute($release)),
        ])->render();
    }
}
