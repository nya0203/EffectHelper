<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;
use nya0203\shape\ShapeShifter;
use nya0203\utils\RotationTypes;

class CircularMotion extends Motion implements RotationTypes {

    /**
     * The spin angle means the angle of rotation per second.
     * The afterimage interval indicates how many seconds the afterimage will be displayed.
     */
    public function __construct(private int|float $spinAngle,
                                private int $rotationType,
                                private float|int|null $afterimageInterval = null) {
    }

    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        $interval = $this->afterimageInterval ?? 0.05;
        $interval = $interval / 0.05;
        $angle = $this->spinAngle * 0.05 * $interval;
        $beforeCount = floor(($time - 1) / $interval);
        for($count = 1; $count <= floor($time / $interval) - $beforeCount; $count++) {
            $rotatedShapeContent = ShapeShifter::rotate($shapeContent, $this->rotationType, $angle * $beforeCount + $angle * $count);
            $content->put($rotatedShapeContent, null, $time);
        }
    }
}