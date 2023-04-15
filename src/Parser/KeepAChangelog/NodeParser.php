<?php

declare(strict_types=1);

namespace PreemStudio\ChangelogParser\Parser\KeepAChangelog;

use Illuminate\Support\Collection;
use PreemStudio\ChangelogParser\Contracts\Node;
use PreemStudio\ChangelogParser\Data\Release;
use PreemStudio\ChangelogParser\Data\Section;

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
            if ($node->isReleaseHeading()) {
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

            if ($node->isChangeTypeHeading()) {
                if (null !== $currentSection) {
                    $currentRelease->setSection(new Section(...$currentSection));
                }

                $currentSection = [
                    'type' => $node->getText(),
                    'content' => null,
                    'description' => null,
                ];
            }

            if ($node->isUnorderedList()) {
                $currentSection['content'] = $node->getText();
            }

            if ($node->isText()) {
                if ($currentSection) {
                    $currentSection['description'] .= $node->getText()."\n";

                    continue;
                }

                if ($currentRelease && empty($currentSection)) {
                    $currentReleaseDescription .= $node->getText();

                    continue;
                }

                if (empty($currentRelease) && empty($currentSection)) {
                    $changelogDescription[] = $node->getText();

                    continue;
                }
            }
        }

        if ($currentSection) {
            $currentRelease->setSection(new Section(...$currentSection));
        }

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
