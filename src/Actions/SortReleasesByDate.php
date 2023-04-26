<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Actions;

use Illuminate\Support\Collection;
use BombenProdukt\ChangelogParser\Data\Release;

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
