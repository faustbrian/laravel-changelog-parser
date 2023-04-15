<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer\Node;

final class Reference extends AbstractNode
{
    public function __construct(
        string $text,
        public readonly string $label,
        public readonly string $destination,
    ) {
        parent::__construct($text);
    }
}
