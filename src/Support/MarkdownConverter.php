<?php

declare(strict_types=1);

namespace BaseCodeOy\ChangelogParser\Support;

use League\CommonMark\CommonMarkConverter;
use Symfony\Component\DomCrawler\Crawler;

final class MarkdownConverter
{
    public static function toString(string $markdown): string
    {
        return (new CommonMarkConverter())->convert($markdown)->getContent();
    }

    public static function toCrawler(string $markdown): Crawler
    {
        return new Crawler(self::toString($markdown));
    }
}
