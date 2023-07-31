<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Data;

use Illuminate\Support\Collection;

final class Changelog
{
    public function __construct(
        private readonly string $description,
        private readonly Collection $releases,
    ) {}

    public function getReleases(): Collection
    {
        return $this->releases;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getUnreleased(): ?Release
    {
        return $this
            ->releases
            ->filter(function (Release $release) {
                return $release->isUnreleased();
            })
            ->first();
    }

    public function getLatestRelease(): Release
    {
        return $this
            ->releases
            ->first();
    }

    public function hasReleases(): bool
    {
        return $this
            ->releases
            ->isNotEmpty();
    }
}
