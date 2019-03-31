<?php

namespace SearchInFile\Modules;

class SplReader implements ReaderInterface
{
    public function read(string $path): \Generator
    {
        $file = new \SplFileObject($path, "rb");
        $stop = null;
        while($stop !== true || !$file->eof()) {
            $stop = yield $file->fgetc();
        }

        $file = null;
    }
}