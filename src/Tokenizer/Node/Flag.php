<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Tokenizer\Node;

final class Flag extends AbstractNode
{
    public function __construct(string $text)
    {
        \preg_match('/^<!--(.*)-->$/s', $text, $matches);

        parent::__construct($matches[1]);
    }
}
