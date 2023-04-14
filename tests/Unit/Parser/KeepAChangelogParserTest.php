<?php

declare(strict_types=1);

namespace Tests\Unit;

use DateTimeInterface;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Data\Section;
use PreemStudio\ChangelogParser\Enum\SectionEnum;
use PreemStudio\ChangelogParser\Parser\KeepAChangelogParser;

beforeEach(function (): void {
    $this->changelog = (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../Fixtures/keep-a-changelog.md'));
});

it('should parse the changelog', function (): void {
    expect($this->changelog->hasReleases())->toBeTrue();
    expect($this->changelog->description)->toBeArray();
    expect($this->changelog->description)->toHaveCount(2);
    expect($this->changelog->releases)->toHaveCount(15);
    expect($this->changelog->getLatestRelease())->toBeInstanceOf(Release::class);
    expect($this->changelog->getUnreleased())->toBeInstanceOf(Release::class);
    expect($this->changelog->getLatestRelease()->tagReference)->not()->toBeNull();
});

it('should get the UNRELEASED release', function (): void {
    $unreleased = $this->changelog->getUnreleased();

    expect($unreleased->version)->toBe(SectionEnum::UNRELEASED->value);
    expect($unreleased->date)->toBeNull();
    expect($unreleased->sections)->toHaveCount(0);
    expect($unreleased->sections->get(SectionEnum::ADDED->value))->toBeNull();
    expect($this->changelog->getLatestRelease()->tagReference)->not()->toBeNull();
});

it('should get the latest release', function (): void {
    $release = $this->changelog->getLatestRelease();

    expect($release->version)->toBe('1.1.1');
    expect($release->isUnreleased())->toBeFalse();
    expect($release->date)->toBeInstanceOf(DateTimeInterface::class);
    expect($release->date->format('Y-m-d'))->toBe('2023-03-05');
    expect($release->sections)->toHaveCount(4);
    expect($release->sections->get(SectionEnum::ADDED->value))->toBeInstanceOf(Section::class);
    expect($release->sections->get(SectionEnum::DEPRECATED->value))->toBeNull();
    expect($release->tagReference)->not()->toBeNull();
});

it('should get the requested section', function (): void {
    $section = $this->changelog->getLatestRelease()->sections->get(SectionEnum::ADDED->value);

    expect($section->type)->toBe(SectionEnum::ADDED->value);
    expect($section->entries)->toBeArray();
    expect($section->entries)->toHaveCount(10);
});
