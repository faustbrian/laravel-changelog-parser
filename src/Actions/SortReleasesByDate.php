<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Actions;

use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Data\Release;

final class SortReleasesByDate
{
    public static function execute(array $releases): Collection
    {
        return collect($releases)->sortByDesc(function (Release $release) {
            if (null === $release->releaseDate) {
                return -1;
            }

            return $release->releaseDate->getTimestamp();
        });
    }
}
