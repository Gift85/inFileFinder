<?php

namespace SearchInFile\Modules;

/**
 * Equals matcher
 */
class StringEntryMatcher implements MatcherInterface
{
    /**
     * @inheritDoc
     */
    public function match(string $needle, string $haystack): bool
    {
        return $needle === $haystack;
    }
}