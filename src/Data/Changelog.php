<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final class Changelog extends Data
{
    public function __construct(
        public readonly Collection $releases,
        public readonly array $description = [],
    ) {
        //
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
