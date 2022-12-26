<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;

class PointShape extends Shape {
    protected function calculate(ShapeContent $content) {
        $content->put(0, 0, 0);
    }
}