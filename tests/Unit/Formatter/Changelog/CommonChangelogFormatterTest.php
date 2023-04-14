<?php

declare(strict_types=1);

namespace Tests\Unit\Formatter\Changelog;

use PreemStudio\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use PreemStudio\ChangelogParser\Formatter\Changelog\CommonChangelogFormatter;
use PreemStudio\ChangelogParser\Parser\CommonChangelogParser;
use function Spatie\Snapshots\assertMatchesSnapshot;

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
