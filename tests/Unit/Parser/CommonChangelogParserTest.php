<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Tests\Unit;

use BaseCodeOy\ChangelogParser\Data\Release;
use BaseCodeOy\ChangelogParser\Data\Section;
use BaseCodeOy\ChangelogParser\Enum\SectionEnum;
use BaseCodeOy\ChangelogParser\Parser\CommonChangelogParser;

beforeEach(function (): void {
    $this->changelog = (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../Fixtures/common-changelog.md'));
});

it('should parse the changelog', function (): void {
    expect($this->changelog->hasReleases())->toBeTrue();
    expect($this->changelog->getDescription())->toBeString();
    expect($this->changelog->getReleases())->toHaveCount(42);
    expect($this->changelog->getLatestRelease())->toBeInstanceOf(Release::class);
    expect($this->changelog->getUnreleased())->toBeNull();
    expect($this->changelog->getLatestRelease()->getTagReference())->not()->toBeNull();
});

it('should get the latest release', function (): void {
    $release = $this->changelog->getLatestRelease();

    expect($release->getVersion())->toBe('8.0.0');
    expect($release->isUnreleased())->toBeFalse();
    expect($release->getDate())->toBeInstanceOf(\DateTimeInterface::class);
    expect($release->getDate()->format('Y-m-d'))->toBe('2022-03-25');
    expect($release->getSections())->toHaveCount(1);
    expect($release->getSections()->get(SectionEnum::CHANGED->value))->toBeInstanceOf(Section::class);
    expect($release->getTagReference())->not()->toBeNull();
});

it('should get the requested section', function (): void {
    $section = $this->changelog->getLatestRelease()->getSections()->get(SectionEnum::CHANGED->value);

    expect($section->getType())->toBe(SectionEnum::CHANGED->value);
    expect($section->getDescription())->toBeString();
});

it('should throw an exception if the changelog contains an UNRELEASED section', function (): void {
    (new CommonChangelogParser())->parse(\file_get_contents(__DIR__.'/../../Fixtures/common-changelog-bad.md'));
})->throws(\Exception::class);
