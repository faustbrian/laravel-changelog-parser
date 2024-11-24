<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Enum;

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
