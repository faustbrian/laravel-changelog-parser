<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Unit\Formatter\Release;

use BaseCodeOy\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Data\Release;
use BaseCodeOy\ChangelogParser\Formatter\Release\KeepAChangelogFormatter;
use BaseCodeOy\ChangelogParser\Parser\KeepAChangelogParser;

it('should format the release', function (): void {
    assertMatchesSnapshot(
        (new KeepAChangelogFormatter())->format(
            (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/keep-a-changelog.md'))->getReleases()->firstWhere(fn (Release $release) => $release->getVersion() === '1.0.0'),
        ),
    );
});

it('should format the release with tag references', function (): void {
    assertMatchesSnapshot(
        (new KeepAChangelogFormatter())->format(
            (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/keep-a-changelog.md'))->getReleases()->first(),
            new ReleaseFormatterConfiguration(
                includeTagReferences: true,
            ),
        ),
    );
});
