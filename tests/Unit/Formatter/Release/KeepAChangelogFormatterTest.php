<?php

declare(strict_types=1);

namespace Tests\Unit\Formatter\Release;

use PreemStudio\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Formatter\Release\KeepAChangelogFormatter;
use PreemStudio\ChangelogParser\Parser\KeepAChangelogParser;
use function Spatie\Snapshots\assertMatchesSnapshot;

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
