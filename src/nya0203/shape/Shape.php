<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;

abstract class Shape {
    protected abstract function calculate(ShapeContent $content);

    public function get(): ShapeContent {
        $content = new ShapeContent();
        $this->calculate($content);
        return $content;
    }
}