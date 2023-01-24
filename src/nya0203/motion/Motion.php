<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;
use nya0203\shape\Shape;

abstract class Motion {
    protected abstract function write(MotionContent $content, ShapeContent $shapeContent, int $time): void;

    /**
     * The duration is in seconds.
     */
    public function get(ShapeContent $shapeContent, int|float $duration): MotionContent {
        $content = new MotionContent();
        $duration = (int)($duration / 0.05);
        for($tick = 0; $tick <= $duration; $tick++) {
            $this->write($content, $shapeContent, $tick);
        }
        return $content;
    }

    public function multi(Motion $subMotion): MultiMotion {
        return new MultiMotion($this, $subMotion);
    }

    public function chain(Motion $subMotion): ChainMotion {
        return new ChainMotion($this, $subMotion);
    }
}