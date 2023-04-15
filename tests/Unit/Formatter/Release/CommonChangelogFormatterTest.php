<?php

declare(strict_types=1);

namespace Tests\Unit\Formatter\Release;

use PreemStudio\ChangelogParser\Configuration\ReleaseFormatterConfiguration;
use PreemStudio\ChangelogParser\Formatter\Release\CommonChangelogFormatter;
use PreemStudio\ChangelogParser\Parser\CommonChangelogParser;
use function Spatie\Snapshots\assertMatchesSnapshot;

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
