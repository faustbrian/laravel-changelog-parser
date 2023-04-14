<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Contracts;

use PreemStudio\ChangelogParser\Data\Changelog;

interface ChangelogFormatter
{
    public function format(Changelog $changelog): string;
}
