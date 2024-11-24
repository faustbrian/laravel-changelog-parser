<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
