<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;

abstract class Shape {
    protected abstract function write(ShapeContent $content): void;

    public function get(): ShapeContent {
        $content = new ShapeContent();
        $this->write($content);
        return $content;
    }
}