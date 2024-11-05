<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Actions;

use BaseCodeOy\ChangelogParser\Data\Release;
use Illuminate\Support\Collection;

final class SortReleasesByDate
{
    public static function execute(array $releases): Collection
    {
        return collect($releases)->sortByDesc(function (Release $release) {
            if (null === $release->getDate()) {
                return -1;
            }

            return $release->getDate()->getTimestamp();
        });
    }
}
