<?php

declare(strict_types=1);

namespace BombenProdukt\ChangelogParser\Parser\KeepAChangelog;

use BombenProdukt\ChangelogParser\Contracts\Node;
use BombenProdukt\ChangelogParser\Data\Release;
use BombenProdukt\ChangelogParser\Data\Section;
use BombenProdukt\ChangelogParser\Tokenizer\Node\ChangeTypeHeading;
use BombenProdukt\ChangelogParser\Tokenizer\Node\ReleaseHeading;
use BombenProdukt\ChangelogParser\Tokenizer\Node\UnorderedList;
use Illuminate\Support\Collection;

final class NodeParser
{
    /**
     * @param Collection<int, Node> $nodes
     */
    public static function parse(Collection $nodes): array
    {
        $releases = [];

        $changelogDescription = [];

        /** @var Release */
        $currentRelease = null;
        $currentReleaseDescription = null;

        /** @var array */
        $currentSection = null;

        foreach ($nodes as $node) {
            if ($node instanceof ReleaseHeading) {
                if (null !== $currentSection) {
                    $currentRelease->setSection(new Section(...$currentSection));

                    $currentSection = null;
                }

                if (null !== $currentRelease) {
                    $releases[] = new Release(
                        $currentRelease->getVersion(),
                        $currentRelease->getDate(),
                        $currentReleaseDescription,
                        $currentRelease->getTagReference(),
                        $currentRelease->getSections(),
                    );
                }

                $currentRelease = new Release($node->getVersion(), $node->getDate());
                $currentReleaseDescription = null;
            }

            if ($node instanceof ChangeTypeHeading) {
                if (null !== $currentSection) {
                    $currentRelease->setSection(new Section(...$currentSection));
                }

                $currentSection = [
                    'type' => $node->getText(),
                    'content' => null,
                    'description' => null,
                ];
            }

            if ($node instanceof UnorderedList) {
                $currentSection['content'] = $node->getText();
            }

            if ($node->isText()) {
                if ($currentSection) {
                    $currentSection['description'] .= $node->getText()."\n";

                    continue;
                }

                /** @phpstan-ignore-next-line */
                if ($currentRelease && empty($currentSection)) {
                    $currentReleaseDescription .= $node->getText();

                    continue;
                }

                /** @phpstan-ignore-next-line */
                if (empty($currentRelease) && empty($currentSection)) {
                    $changelogDescription[] = $node->getText();

                    continue;
                }
            }
        }

        if ($currentSection) {
            $currentRelease->setSection(new Section(...$currentSection));
        }

        /** @phpstan-ignore-next-line */
        if ($currentRelease) {
            $releases[] = new Release(
                $currentRelease->getVersion(),
                $currentRelease->getDate(),
                $currentReleaseDescription,
                $currentRelease->getTagReference(),
                $currentRelease->getSections(),
            );
        }

        return [
            \implode("\n", $changelogDescription),
            $releases,
        ];
    }
}
