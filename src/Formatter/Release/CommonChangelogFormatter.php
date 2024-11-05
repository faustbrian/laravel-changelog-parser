<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Formatter\Release;

use BaseCodeOy\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Contracts\ReleaseFormatter;
use BaseCodeOy\ChangelogParser\Data\Release;
use Illuminate\Support\Facades\View;

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
