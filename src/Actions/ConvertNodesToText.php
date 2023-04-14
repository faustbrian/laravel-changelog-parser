<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Actions;

use Symfony\Component\DomCrawler\Crawler;

final class ConvertNodesToText
{
    public static function execute(Crawler $crawler): array
    {
        return $crawler->each(fn ($node): string => $node->text());
    }
}
