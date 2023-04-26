<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Contracts;

use BombenProdukt\ChangelogParser\Data\Changelog;

interface Parser
{
    public function parse(string $content): Changelog;
}
