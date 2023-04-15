<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer\Node;

final class Link extends AbstractNode
{
    public readonly string $label;

    public readonly string $destination;

    public function __construct(string $text)
    {
        parent::__construct($text);

        \preg_match('/^\[(.*)\]\((.*)\)$/', $text, $matches);

        $this->label = $matches[1];
        $this->destination = $matches[2];
    }
}
