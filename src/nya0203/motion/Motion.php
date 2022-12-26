<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;
use nya0203\shape\Shape;

abstract class Motion {
    protected abstract function calculate(MotionContent $content, ShapeContent $shapeContent);

    public function get(ShapeContent $shapeContent): MotionContent {
        $content = new MotionContent();
        $this->calculate($content, $shapeContent);
        return $content;
    }
}