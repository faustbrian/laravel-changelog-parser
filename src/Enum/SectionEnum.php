<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Enum;

enum SectionEnum: string
{
    case ADDED = 'Added';

    case CHANGED = 'Changed';

    case DEPRECATED = 'Deprecated';

    case FIXED = 'Fixed';

    case REMOVED = 'Removed';

    case SECURITY = 'Security';

    case UNRELEASED = 'Unreleased';

    public static function sortedValues(): array
    {
        return [
            self::ADDED->value,
            self::CHANGED->value,
            self::DEPRECATED->value,
            self::REMOVED->value,
            self::FIXED->value,
            self::SECURITY->value,
        ];
    }
}
