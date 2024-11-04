<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Tokenizer\Node;

final class Flag extends AbstractNode
{
    public function __construct(string $text)
    {
        \preg_match('/^<!--(.*)-->$/s', $text, $matches);

        parent::__construct($matches[1]);
    }
}
