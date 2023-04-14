<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer;

use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Contracts\Tokenizer;
use PreemStudio\ChangelogParser\Tokenizer\Node\AbstractNode;
use PreemStudio\ChangelogParser\Tokenizer\Node\ChangeTypeHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\DocumentHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\Flag;
use PreemStudio\ChangelogParser\Tokenizer\Node\LineBreak;
use PreemStudio\ChangelogParser\Tokenizer\Node\Link;
use PreemStudio\ChangelogParser\Tokenizer\Node\ListItem;
use PreemStudio\ChangelogParser\Tokenizer\Node\Paragraph;
use PreemStudio\ChangelogParser\Tokenizer\Node\Reference;
use PreemStudio\ChangelogParser\Tokenizer\Node\ReleaseHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\ThematicBreak;

final class MarkdownTokenizer implements Tokenizer
{
    public function tokenize(string $markdown): Collection
    {
        /** @var AbstractNode[] */
        $tokens = [];

        $lines = \explode("\n", \trim($markdown));

        foreach ($lines as $index => $line) {
            $lineNumber = $index + 1;
            $token = null;

            $token = match (true) {
                \str_starts_with($line, '---') => new ThematicBreak($lineNumber, '-'),
                \str_starts_with($line, '# ') => new DocumentHeading($lineNumber, \trim(\mb_substr($line, 1))),
                \str_starts_with($line, '## ') => new ReleaseHeading($lineNumber, \trim(\mb_substr($line, 2))),
                \str_starts_with($line, '### ') => new ChangeTypeHeading($lineNumber, \trim(\mb_substr($line, 3))),
                \str_starts_with($line, '-') => new ListItem($lineNumber, \trim(\mb_substr($line, 1))),
                \str_starts_with($line, '*') => new ListItem($lineNumber, \trim(\mb_substr($line, 1))),
                (bool) \preg_match('/^\[(.*)\]: (.*)$/', $line) => new Reference($lineNumber, \trim($line)),
                (bool) \preg_match('/^\[(.*)\]\((.*)\)$/', $line) => new Link($lineNumber, \trim($line)),
                \preg_match('/^<!--(.*)-->$/s', $line, $matches) => new Flag($lineNumber, \trim($matches[1])),
                empty($line) => new LineBreak($lineNumber, "\n"),
                default => new Paragraph($lineNumber, \rtrim($line)),
            };

            // This is a hack to fix the issue where a `p` or `li` is split into multiple lines.
            if ($index > 0) {
                $previousElement = $tokens[0];

                if ($token->isParagraph()) {
                    // if ($previousElement->isParagraph()) {
                    //     $tokens[0] = new Paragraph($previousElement->getLineNumber(), $previousElement->getText() . "\n" . $token->getText());

                    //     continue;
                    // }

                    if ($previousElement->isListItem()) {
                        $tokens[0] = new ListItem($previousElement->getLineNumber(), $previousElement->getText()."\n  ".\preg_replace('/^\s\s/', '', $token->getText()));

                        continue;
                    }
                }
            }

            \array_unshift($tokens, $token);
        }

        return new Collection(\array_reverse($tokens));
    }
}
