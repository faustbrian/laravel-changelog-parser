<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Actions;

use PreemStudio\ChangelogParser\Data\Release;
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
            date: $release->getDate(),
            description: $release->getDescription(),
            /** @phpstan-ignore-next-line */
            sections: $release->getSections()->sortBy(fn ($_, string $key) => \array_search($key, self::ORDER, true)),
            tagReference: $release->getTagReference(),
            version: $release->getVersion(),
        );
    }
}
