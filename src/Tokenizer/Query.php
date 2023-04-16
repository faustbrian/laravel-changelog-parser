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
        $propertyAccessor = 'get'.\ucfirst($property);

        $this->filters[] = fn (Node $node) => $node->{$propertyAccessor}() === $value;

        return $this;
    }

    public function whereType(string $class): self
    {
        $this->filters[] = fn (Node $node) => $node instanceof $class;

        return $this;
    }

    /**
     * @param Collection<int, Node> $nodes
     */
    public function find(Collection $nodes): ?Node
    {
        $result = $this->findAll($nodes)->first();

        if ($result instanceof Node) {
            return $result;
        }

        return null;
    }

    /**
     * @param Collection<int, Node> $nodes
     */
    public function findAll(Collection $nodes): Collection
    {
        foreach ($this->filters as $filter) {
            $nodes = $nodes->where($filter);
        }

        return $nodes;
    }
}
