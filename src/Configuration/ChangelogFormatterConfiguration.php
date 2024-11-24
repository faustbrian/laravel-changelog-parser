<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Configuration;

final class ChangelogFormatterConfiguration
{
    public function __construct(
        public readonly bool $includeHeader = true,
        public readonly bool $includeTagReferences = true,
    ) {
        //
    }
}
