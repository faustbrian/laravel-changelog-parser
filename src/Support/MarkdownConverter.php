<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
