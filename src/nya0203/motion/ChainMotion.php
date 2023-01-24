<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;

class ChainMotion extends Motion {
    private int $preMotionEndTime = 0;

    public function __construct(private Motion $preMotion, private Motion $subMotion) {
    }

    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        $subContent = new MotionContent();
        $this->subMotion->write($subContent, $shapeContent, $time);
        foreach($subContent->get() as $data)
            $content->put($data->getShapeContent(), $data->getOffCenter(), $this->preMotionEndTime + $time);
    }

    public function get(ShapeContent $shapeContent, int|float $duration): MotionContent {
        $content = $this->preMotion->get($shapeContent, $duration);
        $this->preMotionEndTime = $content->getMotionLength();
        $duration = (int)($duration / 0.05);
        for($tick = 0; $tick <= $duration; $tick++)
            $this->write($content, $shapeContent, $tick);
        return $content;
    }
}