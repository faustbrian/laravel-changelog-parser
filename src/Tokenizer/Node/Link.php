<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Tokenizer\Node;

final class Link extends AbstractNode
{
    private readonly string $label;

    private readonly string $destination;

    public function __construct(string $text)
    {
        parent::__construct($text);

        \preg_match('/^\[(.*)\]\((.*)\)$/', $text, $matches);

        $this->label = $matches[1];
        $this->destination = $matches[2];
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }
}
