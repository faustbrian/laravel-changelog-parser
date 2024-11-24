<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Unit\Formatter\Changelog;

use BaseCodeOy\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Formatter\Changelog\CommonChangelogFormatter;
use BaseCodeOy\ChangelogParser\Parser\CommonChangelogParser;

it('should format the changelog', function (): void {
    assertMatchesSnapshot(
        (new CommonChangelogFormatter())->format(
            (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/common-changelog.md')),
        ),
    );
});

it('should format the changelog without tag references', function (): void {
    assertMatchesSnapshot(
        (new CommonChangelogFormatter())->format(
            (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/common-changelog.md')),
            new ChangelogFormatterConfiguration(
                includeTagReferences: false,
            ),
        ),
    );
});
