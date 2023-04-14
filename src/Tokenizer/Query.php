<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer;

use Closure;
use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Contracts\Node;

final class Query
{
    private array $filters = [];

    public function where(Closure $callback): self
    {
        $this->filters[] = $callback;

        return $this;
    }

    public function whereProperty(string $property, mixed $value): self
    {
        $this->filters[] = fn (Node $node) => $node->{$property} === $value;

        return $this;
    }

    public function whereType(string $class): self
    {
        $this->filters[] = fn (Node $node) => $node instanceof $class;

        return $this;
    }

    public function find(Collection $nodes): ?Node
    {
        return $this->findAll($nodes)->first();
    }

    public function findAll(Collection $nodes): Collection
    {
        foreach ($this->filters as $filter) {
            $nodes = $nodes->where($filter);
        }

        return $nodes;
    }
}
