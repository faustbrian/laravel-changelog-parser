<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Enum;

enum SectionEnum: string
{
    case UNRELEASED = 'Unreleased';

    case ADDED = 'Added';

    case CHANGED = 'Changed';

    case FIXED = 'Fixed';

    case DEPRECATED = 'Deprecated';

    case REMOVED = 'Removed';

    case SECURITY = 'Security';
}
