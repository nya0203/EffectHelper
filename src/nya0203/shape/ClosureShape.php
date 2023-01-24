<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;

class ClosureShape extends Shape {
    public function __construct(private Closure $write) {
    }

    protected function write(ShapeContent $content): void {
        ($this->write)($content);
    }
}