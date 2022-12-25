<?php

namespace nya0203\effect\buffer;


class EffectBufferReader {
    private array $buffer;

    public function __construct(EffectBuffer $buffer) {
        $this->buffer = $buffer->get();
    }

    public function getBufferSize(): int {
        return count($this->buffer);
    }

    public function read(): ?array {
        $buffer = $this->buffer;
        if(empty($buffer))
            return null;
        $this->buffer = [];
        return $buffer;
    }

    public function readline(): ?EffectBufferData {
        if(empty($this->buffer))
            return null;
        return array_shift($this->buffer);
    }
}