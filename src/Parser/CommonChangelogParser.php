<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Parser;

use Exception;
use BombenProdukt\ChangelogParser\Contracts\Parser;
use BombenProdukt\ChangelogParser\Data\Changelog;
use BombenProdukt\ChangelogParser\Enum\SectionEnum;
use BombenProdukt\ChangelogParser\Parser\KeepAChangelog\NodeParser;
use BombenProdukt\ChangelogParser\Parser\KeepAChangelog\ReleaseNormalizer;
use BombenProdukt\ChangelogParser\Tokenizer\MarkdownTokenizer;

final class CommonChangelogParser implements Parser
{
    private readonly MarkdownTokenizer $tokenizer;

    public function __construct()
    {
        $this->tokenizer = new MarkdownTokenizer();
    }

    public function parse(string $content): Changelog
    {
        [$description, $releases] = NodeParser::parse($nodes = $this->tokenizer->tokenize($content));

        foreach ($releases as $release) {
            if ($release->getVersion() === SectionEnum::UNRELEASED->value) {
                throw new Exception('Common Changelog does not have an Unreleased section at the top of the changelog.');
            }
        }

        return new Changelog(
            ReleaseNormalizer::normalize($releases, $nodes),
            $description,
        );
    }
}
