<?php

declare(strict_types=1);

namespace nya0203\motion;

use Closure;
use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;

class ClosureMotion extends Motion {
    public function __construct(private Closure $write) {
    }

    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        ($this->write)($content, $shapeContent, $time);
    }
}