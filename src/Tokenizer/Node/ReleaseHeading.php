<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Tokenizer\Node;

use Carbon\Carbon;

final class ReleaseHeading extends AbstractNode
{
    public readonly string $version;

    public readonly ?Carbon $date;

    public function __construct(string $text)
    {
        parent::__construct($text);

        $segments = \explode(' - ', $text);
        $this->version = \str_replace(['[', ']'], '', $segments[0]);

        if (\count($segments) >= 2) {
            $this->date = Carbon::createFromFormat('Y-m-d', $segments[1]);
        } else {
            $this->date = null;
        }
    }
}
