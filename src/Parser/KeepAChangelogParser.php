<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Parser;

use PreemStudio\ChangelogParser\Contracts\Parser;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Parser\KeepAChangelog\NodeParser;
use PreemStudio\ChangelogParser\Parser\KeepAChangelog\ReleaseNormalizer;
use PreemStudio\ChangelogParser\Tokenizer\MarkdownTokenizer;

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
