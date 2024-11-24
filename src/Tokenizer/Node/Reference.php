<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Tokenizer\Node;

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
