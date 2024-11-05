<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Contracts;

use BaseCodeOy\ChangelogParser\Data\Changelog;

interface Parser
{
    public function parse(string $content): Changelog;
}
