<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Parser;

use BombenProdukt\ChangelogParser\Contracts\Parser;
use BombenProdukt\ChangelogParser\Data\Changelog;
use Exception;

final class CommonChangelogParser implements Parser
{
    public function parse(string $content): Changelog
    {
        if (\str_contains($content, '## [Unreleased]')) {
            throw new Exception('Common Changelog does not have an Unreleased section at the top of the changelog.');
        }

        return (new KeepAChangelogParser())->parse($content);
    }
}
