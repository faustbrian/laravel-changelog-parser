<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Contracts;

use BaseCodeOy\ChangelogParser\Configuration\ChangelogFormatterConfiguration;
use BaseCodeOy\ChangelogParser\Data\Changelog;

interface ChangelogFormatter
{
    public function format(Changelog $changelog, ?ChangelogFormatterConfiguration $configuration): string;
}
