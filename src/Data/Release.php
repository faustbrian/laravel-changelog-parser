<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Data;

use BaseCodeOy\ChangelogParser\Enum\SectionEnum;
use DateTimeInterface;
use Illuminate\Support\Collection;

final class Release
{
    private const SECTION_ORDER = [
        SectionEnum::ADDED->value,
        SectionEnum::CHANGED->value,
        SectionEnum::DEPRECATED->value,
        SectionEnum::REMOVED->value,
        SectionEnum::FIXED->value,
        SectionEnum::SECURITY->value,
    ];

    private Collection $sections;

    public function __construct(
        private readonly string $version,
        private readonly ?DateTimeInterface $date = null,
        private readonly ?string $description = null,
        private ?string $tagReference = null,
        private readonly bool $isYanked = false,
    ) {
        $this->sections = collect();
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getDate(): ?DateTimeInterface
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

    public function setTagReference(?string $tagReference): void
    {
        $this->tagReference = $tagReference;
    }

    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function getSection(string $type): ?Section
    {
        return $this
            ->sections
            ->get($type);
    }

    public function setSection(Section $section): self
    {
        $this
            ->sections
            ->put($section->getType(), $section);

        $this->sortSections();

        return $this;
    }

    public function isUnreleased(): bool
    {
        return $this->version === SectionEnum::UNRELEASED->value;
    }

    public function isYanked(): bool
    {
        return $this->isYanked;
    }

    private function sortSections(): void
    {
        $this->sections = $this->sections->sortBy(fn ($_, string $key) => \array_search($key, self::SECTION_ORDER, true));
    }
}
