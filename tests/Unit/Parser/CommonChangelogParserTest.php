<?php

declare(strict_types=1);

namespace Tests\Unit;

use DateTimeInterface;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Data\Section;
use PreemStudio\ChangelogParser\Enum\SectionEnum;
use PreemStudio\ChangelogParser\Parser\CommonChangelogParser;

beforeEach(function (): void {
    $this->changelog = (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../Fixtures/CommonChangelog.md'));
});

it('should parse the changelog', function (): void {
    expect($this->changelog->hasReleases())->toBeTrue();
    expect($this->changelog->description)->toBeArray();
    expect($this->changelog->description)->toHaveCount(9);
    expect($this->changelog->releases)->toHaveCount(42);
    expect($this->changelog->getLatestRelease())->toBeInstanceOf(Release::class);
    expect($this->changelog->getUnreleased())->toBeNull();
    expect($this->changelog->getLatestRelease()->tagReference)->not()->toBeNull();
});

it('should get the latest release', function (): void {
    $release = $this->changelog->getLatestRelease();

    expect($release->version)->toBe('8.0.0');
    expect($release->isUnreleased())->toBeFalse();
    expect($release->releaseDate)->toBeInstanceOf(DateTimeInterface::class);
    expect($release->releaseDate->format('Y-m-d'))->toBe('2022-03-25');
    expect($release->sections)->toHaveCount(1);
    expect($release->sections->get(SectionEnum::CHANGED->value))->toBeInstanceOf(Section::class);
    expect($release->tagReference)->not()->toBeNull();
});

it('should get the requested section', function (): void {
    $section = $this->changelog->getLatestRelease()->sections->get(SectionEnum::CHANGED->value);

    expect($section->type)->toBe(SectionEnum::CHANGED->value);
    expect($section->entries)->toBeArray();
    expect($section->entries)->toHaveCount(1);
});

it('should throw an exception if the changelog contains an UNRELEASED section', function (): void {
    (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../Fixtures/CommonChangelog-Bad.md'));
})->throws(\Exception::class);
