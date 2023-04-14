<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter\Release;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Actions\SortReleaseSections;
use PreemStudio\ChangelogParser\Contracts\ReleaseFormatter;
use PreemStudio\ChangelogParser\Data\Release;

final class CommonChangelogFormatter implements ReleaseFormatter
{
    public function format(Release $release): string
    {
        return View::make('changelog-parser::common-changelog-release', [
            'release' => SortReleaseSections::execute($release),
        ])->render();
    }
}
