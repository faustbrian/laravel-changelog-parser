<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Formatter\Changelog;

use BaseCodeOy\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Contracts\ChangelogFormatter;
use BaseCodeOy\ChangelogParser\Data\Changelog;
use Illuminate\Support\Facades\View;

final class CommonChangelogFormatter implements ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration = null): string
    {
        return View::make('changelog-parser::common-changelog', [
            'configuration' => $configuration ?? new ChangelogFormatterConfiguration(),
            'releases' => $changelog->getReleases(),
        ])->render();
    }
}
