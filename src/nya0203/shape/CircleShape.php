<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;
use nya0203\utils\CircleTypes;

class CircleShape extends Shape implements CircleTypes {
    public function __construct(private int|float $radius, private int $circleType, private int|float $intervalAngle) {
    }

    protected function write(ShapeContent $content): void {
        $type = min(max($this->circleType, self::CIRCLE_XZ), self::CIRCLE_YZ);
        for($angle = 0; $angle < 360; $angle += $this->intervalAngle) {
            $toRadian = deg2rad($angle);
            $a = cos($toRadian) * $this->radius;
            $b = sin($toRadian) * $this->radius;
            switch($type) {
                case self::CIRCLE_XZ :
                    $content->put($a , 0, $b);
                    break;
                case self::CIRCLE_XY :
                    $content->put($a, $b, 0);
                    break;
                case self::CIRCLE_YZ :
                    $content->put(0, $a, $b);
                    break;
            }
        }
    }
}