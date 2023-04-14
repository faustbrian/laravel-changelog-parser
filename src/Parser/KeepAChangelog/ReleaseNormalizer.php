<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Parser\KeepAChangelog;

use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Actions\SortReleasesByDate;
use PreemStudio\ChangelogParser\Contracts\Node;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Tokenizer\Node\Reference;
use PreemStudio\ChangelogParser\Tokenizer\Query;

final class ReleaseNormalizer
{
    /**
     * @param Collection<int, Node> $nodes
     */
    public static function normalize(array $releases, Collection $nodes): Collection
    {
        return SortReleasesByDate::execute($releases)->map(function (Release $release) use ($nodes): Release {
            return new Release(
                $release->version,
                $release->date,
                $release->description,
                (new Query())
                    ->whereType(Reference::class)
                    ->whereProperty('label', $release->version)
                    ->find($nodes)?->href,
                $release->sections,
            );
        });
    }
}
