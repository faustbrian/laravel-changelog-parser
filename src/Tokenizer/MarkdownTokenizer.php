<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer;

use Illuminate\Support\Collection;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\StringContainerInterface;
use League\CommonMark\Parser\MarkdownParser;
use PreemStudio\ChangelogParser\Contracts\Node;
use PreemStudio\ChangelogParser\Contracts\Tokenizer;
use PreemStudio\ChangelogParser\Tokenizer\Node\ChangeTypeHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\DocumentHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\Flag;
use PreemStudio\ChangelogParser\Tokenizer\Node\LineBreak;
use PreemStudio\ChangelogParser\Tokenizer\Node\Link;
use PreemStudio\ChangelogParser\Tokenizer\Node\Paragraph;
use PreemStudio\ChangelogParser\Tokenizer\Node\Reference;
use PreemStudio\ChangelogParser\Tokenizer\Node\ReleaseHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\ThematicBreak;
use PreemStudio\ChangelogParser\Tokenizer\Node\UnorderedList;

final class MarkdownTokenizer implements Tokenizer
{
    /**
     * @return Collection<int, Node>
     */
    public function tokenize(string $content): Collection
    {
        /** @var Node[] */
        $tokens = [];
        $document = $this->createDocument($content);
        $walker = $document->walker();

        while ($event = $walker->next()) {
            $node = $event->getNode();

            if ($node instanceof StringContainerInterface) {
                $line = $node->getLiteral();

                $tokens[] = match (true) {
                    \str_starts_with($line, '---') => new ThematicBreak('-'),
                    \str_starts_with($line, '# ') => new DocumentHeading(\trim(\mb_substr($line, 1))),
                    \str_starts_with($line, '## ') => new ReleaseHeading(\trim(\mb_substr($line, 2))),
                    \str_starts_with($line, '### ') => new ChangeTypeHeading(\trim(\mb_substr($line, 3))),
                    \str_starts_with($line, '-') => new UnorderedList($line),
                    (bool) \preg_match('/^\[(.*)\]\((.*)\)$/', $line) => new Link(\trim($line)),
                    (bool) \preg_match('/^<!--(.*)-->$/s', $line) => new Flag(\trim($line)),
                    empty($line) => new LineBreak("\n"),
                    default => new Paragraph(\rtrim($line)),
                };
            }
        }

        foreach ($document->getReferenceMap() as $reference) {
            $tokens[] = new Reference(
                $reference->getLabel(),
                $reference->getLabel(),
                $reference->getDestination(),
            );
        }

        return new Collection($tokens);
    }

    private function createDocument(string $content): Document
    {
        return (new MarkdownParser(new Environment()))->parse($content);
    }
}
