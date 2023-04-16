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
     * @param  Collection<int, Node>    $nodes
     * @return Collection<int, Release>
     */
    public static function normalize(array $releases, Collection $nodes): Collection
    {
        /** @phpstan-ignore-next-line */
        return SortReleasesByDate::execute($releases)->map(function (Release $release) use ($nodes): Release {
            $reference = (new Query())
                ->whereType(Reference::class)
                ->whereProperty('label', $release->getVersion())
                ->find($nodes);

            return new Release(
                $release->getVersion(),
                $release->getDate(),
                $release->getDescription(),
                $reference instanceof Reference ? $reference->getDestination() : null,
                $release->getSections(),
            );
        });
    }
}
