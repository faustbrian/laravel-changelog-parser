<?php

declare(strict_types=1);

namespace Tests\Unit\Formatter\Changelog;

use PreemStudio\ChangelogParser\Formatter\Changelog\KeepAChangelogFormatter;
use PreemStudio\ChangelogParser\Parser\KeepAChangelogParser;
use function Spatie\Snapshots\assertMatchesSnapshot;

it('should format the changelog', function (): void {
    assertMatchesSnapshot(
        (new KeepAChangelogFormatter())->format(
            (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../../Fixtures/keep-a-changelog.md')),
        ),
    );
});
