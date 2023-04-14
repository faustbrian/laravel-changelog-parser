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

        /** @var array */
        $currentSection = null;

        foreach ($nodes as $node) {
            if ($node->isReleaseHeading()) {
                if (null !== $currentRelease) {
                    $releases[] = $currentRelease;
                }

                if (null !== $currentSection) {
                    $currentRelease->setSection(
                        new Section(
                            $currentSection['type'],
                            $currentSection['entries'],
                            $currentSection['description'],
                        ),
                    );
                }

                $currentRelease = new Release($node->version, $node->date);
            }

            if ($node->isChangeTypeHeading()) {
                if (null !== $currentSection) {
                    $currentRelease->setSection(
                        new Section(
                            $currentSection['type'],
                            $currentSection['entries'],
                            $currentSection['description'],
                        ),
                    );
                }

                $currentSection = [
                    'type' => $node->getText(),
                    'entries' => [],
                    'description' => [],
                ];
            }

            if ($node->isListItem()) {
                $currentSection['entries'][] = $node->getText();
            }

            if ($node->isText()) {
                if ($currentSection) {
                    $currentSection['description'][] = $node->getText();

                    continue;
                }

                if ($currentRelease && empty($currentSection)) {
                    $currentRelease->appendDescription($node->getText());

                    continue;
                }

                if (empty($currentRelease) && empty($currentSection)) {
                    $changelogDescription[] = $node->getText();

                    continue;
                }
            }
        }

        if ($currentRelease) {
            $releases[] = $currentRelease;
        }

        return [$changelogDescription, $releases];
    }
}
