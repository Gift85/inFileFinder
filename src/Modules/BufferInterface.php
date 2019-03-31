<?php


namespace SearchInFile\Modules;


interface BufferInterface
{
    /**
     * Add value to buffer
     * @param string $value
     */
    public function add(string $value): void;

    /**
     * Get buffer current value
     * @return string
     */
    public function value(): string;

    /**
     * Get buffer length
     * @return int
     */
    public function length(): int;

    /**
     * Reset buffer value
     */
    public function reset(): void;

    /**
     * Set buffer max length
     * @param int $length
     */
    public function setLength(int $length): void;

    /**
     * Buffer string representation
     * @return string
     */
    public function __toString(): string;
}