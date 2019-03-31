<?php

namespace SearchInFile\Modules;

/**
 * File reader. Reads file by single character.
 */
class Reader implements ReaderInterface
{
    /**
     * @inheritDoc
     */
    public function read(string $path): \Generator
    {
        $handle = fopen($path, "rb");
        $stop = null;
        while($stop !== 'stop' || !feof($handle)) {
            $stop = yield fgetc($handle);
        }

        fclose($handle);
    }
}