<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Formatter\Release;

use Illuminate\Support\Facades\View;
use PreemStudio\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use PreemStudio\ChangelogParser\Contracts\ReleaseFormatter;
use PreemStudio\ChangelogParser\Data\Release;

final class CommonChangelogFormatter implements ReleaseFormatter
{
    public function format(Release $release, ?ReleaseFormatterConfiguration $configuration = null): string
    {
        return View::make('changelog-parser::common-changelog-release', [
            'configuration' => $configuration ?? new ReleaseFormatterConfiguration(),
            'release' => $release,
        ])->render();
    }
}
