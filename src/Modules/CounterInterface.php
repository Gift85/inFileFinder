<?php


namespace SearchInFile\Modules;


interface CounterInterface
{
    /**
     * Count value
     * @param $value
     */
    public function count($value): void;

    /**
     * Get current counter position
     * @return array
     */
    public function getPosition(): array;

    /**
     * Reset counter
     */
    public function reset(): void;
}