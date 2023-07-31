<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Parser;

use BombenProdukt\ChangelogParser\Contracts\Parser;
use BombenProdukt\ChangelogParser\Data\Changelog;
use BombenProdukt\ChangelogParser\Data\Release;
use BombenProdukt\ChangelogParser\Data\Section;
use BombenProdukt\ChangelogParser\Data\SectionItem;
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
        $releaseData = \explode(' - ', $parsedRelease->text());

        $version = \str_replace(['[', ']'], '', $releaseData[0]);
        $date = \count($releaseData) >= 2
            ? Carbon::createFromFormat('Y-m-d', $releaseData[1])
            : null;

        // TODO: check yanked status

        return new Release(
            $version,
            $date,
            $this->getDescription($parsedRelease->nextAll(), 'h2', 'h3'),
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
