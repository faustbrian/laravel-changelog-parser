<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Contracts;

use PreemStudio\ChangelogParser\Data\Changelog;

interface Parser
{
    public function parse(string $content): Changelog;
}
