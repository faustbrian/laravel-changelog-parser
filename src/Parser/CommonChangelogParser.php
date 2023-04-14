<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Parser;

use Exception;
use PreemStudio\ChangelogParser\Contracts\Parser;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Enum\SectionEnum;
use PreemStudio\ChangelogParser\Parser\KeepAChangelog\NodeParser;
use PreemStudio\ChangelogParser\Parser\KeepAChangelog\ReleaseNormalizer;
use PreemStudio\ChangelogParser\Tokenizer\MarkdownTokenizer;

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
            if ($release->version === SectionEnum::UNRELEASED->value) {
                throw new Exception('Common Changelog does not have an Unreleased section at the top of the changelog.');
            }
        }

        return new Changelog(
            ReleaseNormalizer::normalize($releases, $nodes),
            $description,
        );
    }
}
