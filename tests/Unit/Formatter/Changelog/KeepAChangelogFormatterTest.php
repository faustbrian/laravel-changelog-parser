<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Unit\Formatter\Changelog;

use BaseCodeOy\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Formatter\Changelog\KeepAChangelogFormatter;
use BaseCodeOy\ChangelogParser\Parser\KeepAChangelogParser;

it('should format the changelog', function (): void {
    assertMatchesSnapshot(
        (new KeepAChangelogFormatter())->format(
            (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/keep-a-changelog.md')),
        ),
    );
});

it('should format the changelog without tag references', function (): void {
    assertMatchesSnapshot(
        (new KeepAChangelogFormatter())->format(
            (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/keep-a-changelog.md')),
            new ChangelogFormatterConfiguration(
                includeTagReferences: false,
            ),
        ),
    );
});
