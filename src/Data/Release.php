<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Enum\SectionEnum;
use Spatie\LaravelData\Data;

final class Release extends Data
{
    private const SECTION_ORDER = [
        SectionEnum::ADDED->value,
        SectionEnum::CHANGED->value,
        SectionEnum::DEPRECATED->value,
        SectionEnum::REMOVED->value,
        SectionEnum::FIXED->value,
        SectionEnum::SECURITY->value,
    ];

    public Collection $sections;

    /**
     * @param Collection<int, Section> $sections
     */
    public function __construct(
        public readonly string $version,
        public readonly ?Carbon $date = null,
        public readonly ?string $description = null,
        public readonly ?string $tagReference = null,
        ?Collection $sections = null,
    ) {
        $this->sections = $sections ?? collect();

        $this->sortSections();
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getDate(): ?Carbon
    {
        return $this->date;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getTagReference(): ?string
    {
        return $this->tagReference;
    }

    /**
     * @return Collection<int, Section>
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function setSection(Section $section): void
    {
        $this->sections->put($section->getType(), $section);

        $this->sortSections();
    }

    public function isUnreleased(): bool
    {
        return $this->version === SectionEnum::UNRELEASED->value;
    }

    private function sortSections(): void
    {
        $this->sections = $this->sections->sortBy(fn ($_, string $key) => \array_search($key, self::SECTION_ORDER, true));
    }
}
