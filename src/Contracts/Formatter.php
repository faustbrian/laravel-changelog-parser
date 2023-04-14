<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Contracts;

use PreemStudio\ChangelogParser\Data\Changelog;

interface Formatter
{
    public function format(Changelog $changelog): string;
}
