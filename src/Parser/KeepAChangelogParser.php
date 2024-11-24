<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\ChangelogParser\Parser;

use BaseCodeOy\ChangelogParser\Contracts\Parser;
use BaseCodeOy\ChangelogParser\Data\Changelog;
use BaseCodeOy\ChangelogParser\Data\Release;
use BaseCodeOy\ChangelogParser\Data\Section;
use BaseCodeOy\ChangelogParser\Data\SectionItem;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use League\CommonMark\CommonMarkConverter;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\DomCrawler\Crawler;

final readonly class KeepAChangelogParser implements Parser
{
    private HtmlConverter $htmlConverter;

    public function __construct()
    {
        $this->htmlConverter = new HtmlConverter();
    }

    public function parse(string $content): Changelog
    {
        $content = $this->getChangelogHtml($content);
        $crawler = new Crawler($content);

        $releases = Collection::make();
        $crawledReleases = $crawler->filter('h2');
        $releases = $crawledReleases->each(function (Crawler $crawledRelease) {
            $release = $this->parseRelease($crawledRelease);

            $releaseReference = $crawledRelease->filter('a');

            if ($releaseReference->count()) {
                $release->setTagReference($releaseReference->attr('href'));
            }

            $crawledRelease
                ->nextAll()
                ->filterXPath('h3[preceding-sibling::h2[1][.="'.$crawledRelease->text().'"]]')
                ->each(fn (Crawler $crawledSection) => $release->setSection($this->parseSection($crawledSection)));

            return $release;
        });

        $releases = collect($releases)->sortByDesc(function (Release $release) {
            $releaseDate = $release->getDate();

            if ($releaseDate === null) {
                return -1;
            }

            return $releaseDate->getTimestamp();
        });

        return new Changelog(
            $this->getDescription($crawler->filter('body > *'), 'h1', 'h2'),
            $releases,
        );
    }

    private function parseRelease(Crawler $parsedRelease): Release
    {
        $releaseData = $parsedRelease->text();

        $hasBeenYanked = false;

        if (\str_contains($parsedRelease->text(), '[YANKED]')) {
            $releaseData = \trim(\str_replace('[YANKED]', '', $releaseData));

            $hasBeenYanked = true;
        }

        $releaseData = \explode(' - ', $releaseData);

        $version = \str_replace(['[', ']'], '', $releaseData[0]);
        $date = \count($releaseData) >= 2
            ? Carbon::createFromFormat('Y-m-d', $releaseData[1])
            : null;

        return new Release(
            date: $date,
            description: $this->getDescription($parsedRelease->nextAll(), 'h2', 'h3'),
            isYanked: $hasBeenYanked,
            version: $version,
        );
    }

    private function parseSection(Crawler $parsedSection): Section
    {
        return new Section(
            $parsedSection->text(),
            $parsedSection->nextAll()->first()->children('li')->each(fn ($node) => new SectionItem($node->html(), $this->htmlConverter->convert($node->html()))),
            $this->getDescription($parsedSection->nextAll(), 'h3', 'ul'),
        );
    }

    private function getDescription(Crawler $nodes, string $startTag, string $endTag): string
    {
        $description = [];

        foreach ($nodes as $node) {
            if ($node->nodeName === $startTag) {
                continue;
            }

            if ($node->nodeName === $endTag) {
                break;
            }

            $description[] = $node->ownerDocument->saveHTML($node);
        }

        return \implode('', $description);
    }

    private function getChangelogHtml($markdown): string
    {
        return (new CommonMarkConverter([
            'renderer' => [
                'soft_break' => '<br>',
            ],
        ]))->convert($markdown)->getContent();
    }
}
