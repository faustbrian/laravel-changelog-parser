<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Enum;

enum SectionEnum: string
{
    case ADDED = 'Added';

    case CHANGED = 'Changed';

    case DEPRECATED = 'Deprecated';

    case FIXED = 'Fixed';

    case REMOVED = 'Removed';

    case SECURITY = 'Security';

    case UNRELEASED = 'Unreleased';
}
