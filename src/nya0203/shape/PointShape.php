<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;

class PointShape extends Shape {
    protected function write(ShapeContent $content): void {
        $content->put(0, 0, 0);
    }
}