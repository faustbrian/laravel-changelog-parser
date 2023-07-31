<?php

declare(strict_types=1);

namespace Tests\Unit;

use BombenProdukt\ChangelogParser\Data\Release;
use BombenProdukt\ChangelogParser\Data\Section;
use BombenProdukt\ChangelogParser\Enum\SectionEnum;
use BombenProdukt\ChangelogParser\Parser\KeepAChangelogParser;
use DateTimeInterface;

beforeEach(function (): void {
    $this->changelog = (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../Fixtures/keep-a-changelog.md'));
});

it('should parse the changelog', function (): void {
    expect($this->changelog->hasReleases())->toBeTrue();
    expect($this->changelog->getDescription())->toBeString();
    expect($this->changelog->getReleases())->toHaveCount(15);
    expect($this->changelog->getLatestRelease())->toBeInstanceOf(Release::class);
    expect($this->changelog->getUnreleased())->toBeInstanceOf(Release::class);
    expect($this->changelog->getLatestRelease()->getTagReference())->not()->toBeNull();
});

it('should get the UNRELEASED release', function (): void {
    $unreleased = $this->changelog->getUnreleased();

    expect($unreleased->getVersion())->toBe(SectionEnum::UNRELEASED->value);
    expect($unreleased->getDate())->toBeNull();
    expect($unreleased->getSections())->toHaveCount(0);
    expect($unreleased->getSections()->get(SectionEnum::ADDED->value))->toBeNull();
    expect($this->changelog->getLatestRelease()->getTagReference())->not()->toBeNull();
});

it('should get the latest release', function (): void {
    $release = $this->changelog->getLatestRelease();

    expect($release->getVersion())->toBe('1.1.1');
    expect($release->isUnreleased())->toBeFalse();
    expect($release->getDate())->toBeInstanceOf(DateTimeInterface::class);
    expect($release->getDate()->format('Y-m-d'))->toBe('2023-03-05');
    expect($release->getSections())->toHaveCount(4);
    expect($release->getSections()->get(SectionEnum::ADDED->value))->toBeInstanceOf(Section::class);
    expect($release->getSections()->get(SectionEnum::DEPRECATED->value))->toBeNull();
    expect($release->getTagReference())->not()->toBeNull();
});

it('should get the requested section', function (): void {
    $section = $this->changelog->getLatestRelease()->getSections()->get(SectionEnum::ADDED->value);

    expect($section->getType())->toBe(SectionEnum::ADDED->value);
    expect($section->getDescription())->toBeString();
});

it('should include release and section descriptions', function (): void {
    $changelog = (new KeepAChangelogParser())->parse(\file_get_contents(__DIR__.'/../../Fixtures/keep-a-changelog-with-descriptions.md'));

    expect($changelog->getDescription())->toBe(
        '<p>All notable changes to this project will be documented in this file.</p><p>The format is based on <a href="https://keepachangelog.com/en/1.0.0/">Keep a Changelog</a>,<br>and this project adheres to <a href="https://semver.org/spec/v2.0.0.html">Semantic Versioning</a>.</p>',
    );

    foreach ($changelog->getReleases() as $release) {
        expect($release->getDescription())->toBe(
            '<p>In the latest release, I\'ve added support for commit message and description suggestions via an integration with OpenAI. Commit looks at all of your changes, and feeds that into the machine with a bit of prompt-tuning to get back a commit message that does a surprisingly good job at describing the intent of your changes.</p><p>It\'s also been a pretty helpful way to remind myself what the hell I was working on at the end of the day yesterday when I get back to my computer and realize I didn\'t commit any of my work.</p><p><a href="https://google.com">Some release description.</a></p><p>In the latest release, I\'ve added support for commit message and description suggestions via an integration with OpenAI. Commit looks at all of your changes, and feeds that into the machine with a bit of prompt-tuning to get back a commit message that does a surprisingly good job at describing the intent of your changes.</p><p>It\'s also been a pretty helpful way to remind myself what the hell I was working on at the end of the day yesterday when I get back to my computer and realize I didn\'t commit any of my work.</p>',
        );
    }
});
