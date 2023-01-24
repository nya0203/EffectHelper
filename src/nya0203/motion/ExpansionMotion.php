<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;
use nya0203\shape\ShapeShifter;

class ExpansionMotion extends Motion {
    /**
     * The expansion scale is the scale to scale per second.
     * The afterimage interval indicates how many seconds the afterimage will be displayed.
     */
    public function __construct(private float|int $expansionScale, private float|int|null $afterimageInterval = null) {

    }
    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        $interval = $this->afterimageInterval ?? 0.05;
        $interval = $interval/0.05;
        $expansionScale = $this->expansionScale * 0.05;
        $beforeCount = floor(($time - 1) / $interval);
        for($count = 1; $count <= floor($time / $interval) - $beforeCount; $count++) {
            $scale = $expansionScale * $interval;
            $rescaledShapeContent = ShapeShifter::rescale($shapeContent, 1 + $scale * $beforeCount + $scale * $count);
            $content->put($rescaledShapeContent, null, $time);
        }
    }
}