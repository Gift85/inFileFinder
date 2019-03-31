<?php

namespace SearchInFile\Facade;

use SearchInFile\Exceptions\CommonException;
use SearchInFile\Modules\Buffer;
use SearchInFile\Modules\Counter;
use SearchInFile\Modules\Reader;
use SearchInFile\Modules\StringEntryMatcher;
use SearchInFile\Searcher;
use Symfony\Component\Yaml\Yaml;

class SearchInFile
{
    /**
     * Simple default usage helper
     * @param $path
     * @param $search
     * @return array
     * @throws CommonException
     */
    public static function search($path, $search)
    {
        $searcher = new Searcher(
            Yaml::parseFile(__DIR__ . '/../config.yaml'),
            new StringEntryMatcher(),
            new Reader(),
            new Counter(),
            new Buffer()
        );
        $searcher->setFilePath($path);
        $searcher->setSearchString($search);
        return $searcher->search();
    }
}