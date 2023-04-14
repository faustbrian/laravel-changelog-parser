<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Actions;

use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Data\Section;
use PreemStudio\ChangelogParser\Enum\SectionEnum;

final class SortReleaseSections
{
    private const ORDER = [
        SectionEnum::ADDED->value,
        SectionEnum::CHANGED->value,
        SectionEnum::DEPRECATED->value,
        SectionEnum::REMOVED->value,
        SectionEnum::FIXED->value,
        SectionEnum::SECURITY->value,
    ];

    public static function execute(Release $release): Release
    {
        return new Release(
            date: $release->date,
            description: $release->description,
            sections: $release->sections->sortBy(fn (Section $section, string $key) => \array_search($key, self::ORDER, true)),
            tagReference: $release->tagReference,
            version: $release->version,
        );
    }
}
