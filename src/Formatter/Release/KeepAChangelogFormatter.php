<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Formatter\Release;

use BaseCodeOy\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Contracts\ReleaseFormatter;
use BaseCodeOy\ChangelogParser\Data\Release;
use Illuminate\Support\Facades\View;

final class KeepAChangelogFormatter implements ReleaseFormatter
{
    public function format(Release $release, ?ReleaseFormatterConfiguration $configuration = null): string
    {
        return View::make('changelog-parser::keep-a-changelog-release', [
            'configuration' => $configuration ?? new ReleaseFormatterConfiguration(),
            'release' => $release,
        ])->render();
    }
}
