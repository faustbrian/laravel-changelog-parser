<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Data;

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
