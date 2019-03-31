<?php

namespace SearchInFile;

use SearchInFile\Exceptions\CommonException;
use SearchInFile\Modules\BufferInterface;
use SearchInFile\Modules\CounterInterface;
use SearchInFile\Modules\MatcherInterface;
use SearchInFile\Modules\ReaderInterface;

/**
 * Class Searcher
 * Search string in file
 */
class Searcher
{
    /**
     * Config
     * @var array
     */
    private $config;

    /**
     * Search matcher
     * @var MatcherInterface
     */
    private $matcher;

    /**
     * File reader
     * @var ReaderInterface
     */
    private $reader;

    /**
     * Path to file
     * @var string
     */
    private $filePath;

    /**
     * Search string
     * @var string
     */
    private $searchString;

    /**
     * Counter
     * @var CounterInterface
     */
    private $counter;

    /**
     * Find first or all
     * @var bool
     */
    private $findFirst = true;

    /**
     * Buffer
     * @var BufferInterface
     */
    private $buffer;

    /**
     * Searcher constructor.
     * @param array $config
     * @param MatcherInterface $matcher
     * @param ReaderInterface $reader
     * @param CounterInterface $counter
     * @param BufferInterface $buffer
     */
    public function __construct(
        array $config,
        MatcherInterface $matcher,
        ReaderInterface $reader,
        CounterInterface $counter,
        BufferInterface $buffer
    ) {
        $this->config = $config;
        $this->matcher = $matcher;
        $this->reader = $reader;
        $this->counter = $counter;
        $this->buffer = $buffer;
    }

    /**
     * Check file
     * @throws CommonException
     */
    private function checkFile(): void
    {
        if (!file_exists($this->filePath)) {
            throw new CommonException("file {$this->filePath} not exists");
        }
        if (!is_readable($this->filePath)) {
            throw new CommonException("file {$this->filePath} not readable");
        }
        if ($this->config['types'] && !in_array(mime_content_type($this->filePath), $this->config['types'])) {
            throw new CommonException('unsupported type');
        }
        if ($this->config['sizeLimit'] && filesize($this->filePath) > $this->config['sizeLimit']) {
            throw new CommonException('file too large');
        }
    }

    /**
     * Set file
     * @param string $path
     * @throws CommonException
     */
    public function setFilePath(string $path): void
    {
        $this->filePath = $path;
        $this->checkFile();
    }

    /**
     * Set search string
     * @param string $string
     * @throws CommonException
     */
    public function setSearchString(string $string): void
    {
        if (strlen($string) < 1) {
            throw new CommonException('nothing to search');
        }
        $this->searchString = $string;
        $this->buffer->setLength(strlen($string));
    }

    /**
     * Search
     * @return array
     */
    public function search(): array
    {
        $readResult = $this->reader->read($this->filePath);
        $result = [];

        foreach ($readResult as $value) {
            $this->counter->count($value);
            $this->buffer->add($value);

            if ($this->matcher->match($this->searchString, $this->buffer)) {
                [$lineNumber, $symbolNumber] = $this->counter->getPosition();
                $result[$lineNumber] = $symbolNumber - $this->buffer->length();

                if ($this->findFirst) {
                    $readResult->send('stop');
                    return $result;
                }
            }
        }
        $this->counter->reset();
        $this->buffer->reset();
        return $result;
    }
}