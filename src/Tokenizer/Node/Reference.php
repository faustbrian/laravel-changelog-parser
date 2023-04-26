<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Tokenizer\Node;

final class Reference extends AbstractNode
{
    public function __construct(
        string $text,
        private readonly string $label,
        private readonly string $destination,
    ) {
        parent::__construct($text);
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
