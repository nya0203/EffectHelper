<?php

declare(strict_types=1);

namespace nya0203\content\motion;

use nya0203\content\shape\ShapeContent;
use pocketmine\math\Vector3;

class MotionContent {
    /** @var MotionContentData[] */
    private array $content = [];
    private int $motionLength = 0;

    public function put(ShapeContent $shapeContent, ?Vector3 $offCenter, int $time): void {
        $this->content[] = new MotionContentData($shapeContent, $offCenter ?? new Vector3(0, 0, 0), $time);
        $this->motionLength = max($this->motionLength, $time);
    }

    /** @return MotionContentData[] */
    public function get(): array {
        return $this->content;
    }

    public function getMotionLength(): int {
        return $this->motionLength;
    }

    public function isEmpty(): bool {
        return empty($this->content);
    }
}