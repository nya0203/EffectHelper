<?php

declare(strict_types=1);

namespace nya0203\content\motion;

use nya0203\content\shape\ShapeContent;
use pocketmine\math\Vector3;

class MotionContentData {
    private array $data = [];

    public function __construct(private ShapeContent $shapeContent, private Vector3 $offCenter, private int $time) {
    }

    public function getOffCenter(): Vector3 {
        return $this->offCenter;
    }

    public function getTime(): int {
        return $this->time;
    }

    public function getShapeContent(): ShapeContent {
        return $this->shapeContent;
    }
}