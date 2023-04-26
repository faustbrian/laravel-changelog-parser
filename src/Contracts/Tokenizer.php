<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Contracts;

use Illuminate\Support\Collection;

interface Tokenizer
{
    public function tokenize(string $content): Collection;
}
