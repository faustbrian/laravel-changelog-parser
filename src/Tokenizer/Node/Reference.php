<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer\Node;

final class Reference extends AbstractNode
{
    public readonly string $label;

    public readonly string $href;

    public function __construct(int $lineNumber, string $text)
    {
        parent::__construct($lineNumber, $text);

        \preg_match('/^\[(.*)\]: (.*)$/', $text, $matches);

        $this->label = $matches[1];
        $this->href = $matches[2];
    }
}
