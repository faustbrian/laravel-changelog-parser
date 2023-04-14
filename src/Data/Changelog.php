<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final class Changelog extends Data
{
    public readonly Collection $releases;

    public function __construct(
        array $releases,
        public readonly array $description = [],
    ) {
        // We cast the releases to a collection and sort them by release date
        // to make sure the latest release is always the first one in the collection.
        $this->releases = collect($releases)->sortByDesc(function (Release $release) {
            $releaseDate = $release->releaseDate;

            if (null === $releaseDate) {
                return -1;
            }

            return $releaseDate->getTimestamp();
        });
    }

    public function hasReleases(): bool
    {
        return $this->releases->isNotEmpty();
    }

    public function getUnreleased(): ?Release
    {
        return $this->releases->filter(fn (Release $release): bool => $release->isUnreleased())->first();
    }

    public function getLatestRelease(): Release
    {
        return $this->releases->first();
    }
}
