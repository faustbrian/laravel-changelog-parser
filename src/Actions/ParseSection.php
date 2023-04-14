<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Actions;

use PreemStudio\ChangelogParser\Data\Section;
use Symfony\Component\DomCrawler\Crawler;

final class ParseSection
{
    public static function execute(Crawler $parsedSection): Section
    {
        return new Section(
            $parsedSection->text(),
            ConvertNodesToText::execute($parsedSection->nextAll()->first()->children('li')),
        );
    }
}
