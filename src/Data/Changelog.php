<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

final class Changelog extends Data
{
    /**
     * @param Collection<int, Release> $releases
     */
    public function __construct(
        public readonly Collection $releases,
        public readonly ?string $description = null,
    ) {
        //
    }

    /**
     * @return Collection<int, Release>
     */
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

    public function getLatestRelease(): ?Release
    {
        return $this->releases->first();
    }

    public function hasReleases(): bool
    {
        return $this->releases->isNotEmpty();
    }
}
