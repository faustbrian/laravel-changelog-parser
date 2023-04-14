<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Contracts;

use Illuminate\Support\Collection;

interface Tokenizer
{
    public function tokenize(string $content): Collection;
}
