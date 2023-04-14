<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer;

use Closure;
use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Contracts\Node;

final class NodeWalker
{
    /**
     * This value is -1 because the first call to next() will increment it to 0.
     */
    private int $currentIndex = -1;

    public function __construct(private readonly Collection $nodes)
    {
        //
    }

    public function walk(Closure $onEntry): void
    {
        while ($this->hasMore()) {
            $onEntry(
                $this->next(),
                // This is a new instance of the walker with the remaining nodes.
                new self($this->nodes->toBase()->splice($this->currentIndex)),
            );
        }
    }

    public function get(int $index): ?Node
    {
        return $this->nodes->get($index);
    }

    public function first(): Node
    {
        return $this->nodes->first();
    }

    public function last(): Node
    {
        return $this->nodes->last();
    }

    public function next(): ?Node
    {
        $this->currentIndex++;

        return $this->get($this->currentIndex);
    }

    public function previous(): ?Node
    {
        $this->currentIndex--;

        return $this->get($this->currentIndex);
    }

    public function hasMore(): bool
    {
        return $this->currentIndex < $this->nodes->count() - 1;
    }
}
