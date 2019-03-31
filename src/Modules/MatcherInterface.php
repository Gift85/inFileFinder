<?php

namespace SearchInFile\Modules;

interface MatcherInterface
{
    /**
     * Matches values
     * @param string $needle
     * @param string $haystack
     * @return bool
     */
    public function match(string $needle, string $haystack): bool;
}