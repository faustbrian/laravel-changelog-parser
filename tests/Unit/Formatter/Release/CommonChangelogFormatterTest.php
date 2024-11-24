<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Unit\Formatter\Release;

use BaseCodeOy\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Formatter\Release\CommonChangelogFormatter;
use BaseCodeOy\ChangelogParser\Parser\CommonChangelogParser;

it('should format the release', function (): void {
    assertMatchesSnapshot(
        (new CommonChangelogFormatter())->format(
            (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/common-changelog.md'))->getReleases()->first(),
        ),
    );
});

it('should format the release with tag references', function (): void {
    assertMatchesSnapshot(
        (new CommonChangelogFormatter())->format(
            (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/common-changelog.md'))->getReleases()->first(),
            new ReleaseFormatterConfiguration(
                includeTagReferences: true,
            ),
        ),
    );
});
