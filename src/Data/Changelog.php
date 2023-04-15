<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final class Changelog extends Data
{
    public function __construct(
        private readonly Collection $releases,
        private readonly ?string $description = null,
    ) {
        //
    }

    public function getReleases(): Collection
    {
        return $this->releases;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getUnreleased(): ?Release
    {
        return $this->releases->filter(fn (Release $release): bool => $release->isUnreleased())->first();
    }

    public function getLatestRelease(): Release
    {
        return $this->releases->first();
    }

    public function hasReleases(): bool
    {
        return $this->releases->isNotEmpty();
    }
}
