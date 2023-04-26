<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Formatter\Release;

use BombenProdukt\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use BombenProdukt\ChangelogParser\Contracts\ReleaseFormatter;
use BombenProdukt\ChangelogParser\Data\Release;
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
