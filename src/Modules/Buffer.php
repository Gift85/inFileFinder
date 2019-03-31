<?php

namespace SearchInFile\Modules;

/**
 * Buffer
 */
class Buffer implements BufferInterface
{
    /**
     * Buffer length
     * @var int
     */
    private $length = 0;

    /**
     * Buffer
     * @var array
     */
    private $buffer = [];

    /**
     * @inheritDoc
     */
    public function add(string $value): void
    {
        if (count($this->buffer) === $this->length) {
            array_shift($this->buffer);
        }
        $this->buffer[] = $value;
    }

    /**
     * @inheritDoc
     */
    public function value(): string
    {
        return implode($this->buffer);
    }

    /**
     * @inheritDoc
     */
    public function length(): int
    {
        return $this->length;
    }

    /**
     * @inheritDoc
     */
    public function reset(): void
    {
        $this->buffer = [];
    }

    /**
     * @inheritDoc
     */
    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->value();
    }
}