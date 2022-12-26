<?php

declare(strict_types=1);

namespace nya0203\content\motion;

use nya0203\content\shape\ShapeContent;
use pocketmine\math\Vector3;

class MotionContent {
    /** @var MotionContentData[] */
    private array $content = [];

    public function put(ShapeContent $shapeContent, Vector3 $offCenter, int $time): void {
        $this->content[] = new MotionContentData($shapeContent, $offCenter, $time);
    }

    public function putContentData(MotionContentData $contentData): void {
        $this->content[] = $contentData;
    }

    /** @return MotionContentData[] */
    public function get(): array {
        return $this->content;
    }
}