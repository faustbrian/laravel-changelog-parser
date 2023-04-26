<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Parser\KeepAChangelog;

use BombenProdukt\ChangelogParser\Actions\SortReleasesByDate;
use BombenProdukt\ChangelogParser\Contracts\Node;
use BombenProdukt\ChangelogParser\Data\Release;
use BombenProdukt\ChangelogParser\Tokenizer\Node\Reference;
use BombenProdukt\ChangelogParser\Tokenizer\Query;
use Illuminate\Support\Collection;

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
