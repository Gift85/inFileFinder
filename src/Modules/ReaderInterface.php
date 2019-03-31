<?php

namespace SearchInFile\Modules;

interface ReaderInterface
{
    /**
     * Reads file
     * @param string $path
     * @return \Generator
     */
    public function read(string $path): \Generator;
}