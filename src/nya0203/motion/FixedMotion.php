<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;

class FixedMotion extends Motion {
    /**
     * The afterimage interval indicates how many seconds the afterimage will be displayed.
     */
    public function __construct(private float|int|null $afterimageInterval = null) {
    }

    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        $interval = ($this->afterimageInterval ?? 0.05) / 0.05;
        if($time % $interval == 0)
            $content->put($shapeContent, null, $time);
    }
}