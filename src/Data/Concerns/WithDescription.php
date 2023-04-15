<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Data\Concerns;

trait WithDescription
{
    public function setDescription(array $description): void
    {
        $this->description = $description;
    }

    public function appendDescription(string $description): void
    {
        $this->description .= $description."\n";
    }
}
