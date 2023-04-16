<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Parser\KeepAChangelog;

use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Contracts\Node;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Data\Section;
use PreemStudio\ChangelogParser\Tokenizer\Node\ChangeTypeHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\ReleaseHeading;
use PreemStudio\ChangelogParser\Tokenizer\Node\UnorderedList;

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
