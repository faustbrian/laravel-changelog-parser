<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Parser;

use BombenProdukt\ChangelogParser\Contracts\Parser;
use BombenProdukt\ChangelogParser\Data\Changelog;
use BombenProdukt\ChangelogParser\Parser\KeepAChangelog\NodeParser;
use BombenProdukt\ChangelogParser\Parser\KeepAChangelog\ReleaseNormalizer;
use BombenProdukt\ChangelogParser\Tokenizer\MarkdownTokenizer;

final class KeepAChangelogParser implements Parser
{
    private readonly MarkdownTokenizer $tokenizer;

    public function __construct()
    {
        $this->tokenizer = new MarkdownTokenizer();
    }

    public function parse(string $content): Changelog
    {
        [$description, $releases] = NodeParser::parse($nodes = $this->tokenizer->tokenize($content));

        return new Changelog(
            ReleaseNormalizer::normalize($releases, $nodes),
            $description,
        );
    }
}
