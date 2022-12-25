<?php

declare(strict_types=1);

namespace nya0203\effect\buffer;

class EffectBufferReader {
    private array $buffer;

    public function __construct(EffectBuffer $buffer) {
        $this->buffer = $buffer->get();
    }

    public function getBufferSize(): int {
        return count($this->buffer);
    }

    /** @return EffectBufferData[] */
    public function read(): array {
        $buffer = $this->buffer;
        $this->buffer = [];
        return $buffer;
    }

    public function readline(): ?EffectBufferData {
        if(empty($this->buffer))
            return null;
        return array_shift($this->buffer);
    }
}