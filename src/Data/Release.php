<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Enum\SectionEnum;
use Spatie\LaravelData\Data;

final class Release extends Data
{
    public readonly Collection $sections;

    public function __construct(
        public readonly string $version,
        public readonly ?Carbon $releaseDate = null,
        public ?string $tagReference = null,
    ) {
        $this->sections = collect();
    }

    public function setSection(Section $section): void
    {
        $this->sections->put($section->type, $section);
    }

    public function isUnreleased(): bool
    {
        return $this->version === SectionEnum::UNRELEASED->value;
    }
}
