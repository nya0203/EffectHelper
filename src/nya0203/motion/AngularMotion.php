<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;
use nya0203\shape\ShapeShifter;
use nya0203\utils\CircleTypes;
use nya0203\utils\RotationTypes;
use pocketmine\math\Vector3;

class AngularMotion extends Motion implements RotationTypes {
    /**
     * The speed is the angular change per second.
     * The afterimage interval is an angle unit.
     */
    public function __construct(private float|int $radius,
                                private float|int $speed,
                                private int $rotationType,
                                private float|int $startAngle = 0,
                                private float|int|null $afterimageInterval = null) {
    }

    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        $type = min(max($this->rotationType, self::ROTATION_ROLL), self::ROTATION_PITCH);
        $speed = $this->speed * 0.05;
        $interval = $this->afterimageInterval ?? abs($speed);
        $interval = $interval * ($speed / abs($speed));
        $beforeCount = floor($speed * ($time - 1) / $interval);
        $angle = deg2rad($this->startAngle);
        $a = cos($angle) * $this->radius;
        $b = sin($angle) * $this->radius;
        $startPos = new Vector3(0, 0, 0);
        switch($type) {
            case self::ROTATION_YAW :
                $startPos = new Vector3($a, 0, $b);
                break;
            case self::ROTATION_PITCH :
                $startPos = new Vector3($a, $b, 0);
                break;
            case self::ROTATION_ROLL :
                $startPos = new Vector3(0, $a, $b);
                break;
        }
        $shapeContent = ShapeShifter::move($shapeContent, $startPos->getX(), $startPos->getY(), $startPos->getZ());
        for($count = 1; $count <= floor($speed * $time / $interval) - $beforeCount; $count++) {
            $rotatedShapeContent = ShapeShifter::rotate($shapeContent, $this->rotationType, $interval * max($beforeCount, 0) + $interval * $count);
            $content->put($rotatedShapeContent, null, $time);
        }
    }
}