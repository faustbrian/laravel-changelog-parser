<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Tokenizer\Node;

use Carbon\Carbon;

final class ReleaseHeading extends AbstractNode
{
    private readonly string $version;

    private readonly ?Carbon $date;

    public function __construct(string $text)
    {
        parent::__construct($text);

        $segments = \explode(' - ', $text);
        $this->version = \str_replace(['[', ']'], '', $segments[0]);

        if (\count($segments) >= 2) {
            $releaseDate = Carbon::createFromFormat('Y-m-d', $segments[1]);

            if ($releaseDate === false) {
                throw new \InvalidArgumentException('Invalid release date format');
            }

            $this->date = $releaseDate;
        } else {
            $this->date = null;
        }
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getDate(): ?Carbon
    {
        return $this->date;
    }
}
