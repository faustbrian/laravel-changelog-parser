<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Parser;

use Exception;
use PreemStudio\ChangelogParser\Actions\ConvertNodesToText;
use PreemStudio\ChangelogParser\Actions\ParseRelease;
use PreemStudio\ChangelogParser\Actions\ParseSection;
use PreemStudio\ChangelogParser\Actions\SortReleasesByDate;
use PreemStudio\ChangelogParser\Contracts\Parser;
use PreemStudio\ChangelogParser\Data\Changelog;
use PreemStudio\ChangelogParser\Enum\SectionEnum;
use PreemStudio\ChangelogParser\Support\MarkdownConverter;
use Symfony\Component\DomCrawler\Crawler;

final class CommonChangelogParser implements Parser
{
    public function parse(string $content): Changelog
    {
        $crawler = MarkdownConverter::toCrawler($content);

        return new Changelog(
            SortReleasesByDate::execute(
                $crawler->filter('h2')->each(function (Crawler $crawledRelease) {
                    $release = ParseRelease::execute($crawledRelease);

                    if ($release->version === SectionEnum::UNRELEASED->value) {
                        throw new Exception('Common Changelog does not have an Unreleased section at the top of the changelog.');
                    }

                    $releaseReference = $crawledRelease->filter('a');

                    if ($releaseReference->count()) {
                        $release->tagReference = $releaseReference->attr('href');
                    }

                    $crawledRelease
                        ->nextAll()
                        ->filterXPath('h3[preceding-sibling::h2[1][.="'.$crawledRelease->text().'"]]')
                        ->each(fn (Crawler $crawledSection) => $release->setSection(ParseSection::execute($crawledSection)));

                    return $release;
                }),
            ),
            ConvertNodesToText::execute($crawler->filter('h1 ~ p')),
        );
    }
}
