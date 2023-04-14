<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Actions;

use Carbon\Carbon;
use PreemStudio\ChangelogParser\Data\Release;
use Symfony\Component\DomCrawler\Crawler;

final class ParseRelease
{
    public static function execute(Crawler $parsedRelease): Release
    {
        $releaseData = \explode(' - ', $parsedRelease->text());
        $version = \str_replace(['[', ']'], '', $releaseData[0]);

        if (\count($releaseData) >= 2) {
            return new Release($version, Carbon::createFromFormat('Y-m-d', $releaseData[1]));
        }

        return new Release($version);
    }
}
