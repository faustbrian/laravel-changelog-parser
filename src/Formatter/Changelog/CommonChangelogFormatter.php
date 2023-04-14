<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter\Changelog;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Actions\SortReleaseSections;
use PreemStudio\ChangelogParser\Contracts\ChangelogFormatter;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Data\Release;

final class CommonChangelogFormatter implements ChangelogFormatter
{
    public function format(Changelog $changelog): string
    {
        return View::make('changelog-parser::common-changelog', [
            'releases' => $changelog->releases->map(fn (Release $release): Release => SortReleaseSections::execute($release)),
        ])->render();
    }
}
