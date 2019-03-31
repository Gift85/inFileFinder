<?php

namespace SearchInFile\Modules;

/**
 * Counter
 */
class Counter implements CounterInterface
{
    /**
     * Line number
     * @var int
     */
    private $line = 1;

    /**
     * Symbol in line position
     * @var int
     */
    private $position = 0;

    /**
     * @inheritDoc
     */
    public function count($value): void
    {
        $this->position++;

        if ($value === PHP_EOL) {
            $this->line++;
            $this->position = 0;
        }
    }

    /**
     * @inheritDoc
     */
    public function getPosition(): array
    {
        return [$this->line, $this->position];
    }

    /**
     * @inheritDoc
     */
    public function reset(): void
    {
        $this->line = 0;
        $this->position = 0;
    }
}