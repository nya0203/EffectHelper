<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;

class MultiMotion extends Motion {
    /**
     * The sub motion requires writing content for all times.
     */
    public function __construct(private Motion $preMotion, private Motion $subMotion) {

    }
    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        $preMotionContent = new MotionContent();
        $this->preMotion->write($preMotionContent, $shapeContent, $time);
        foreach($preMotionContent->get() as $preData) {
            $subMotionContent = new MotionContent();
            $this->subMotion->write($subMotionContent, $preData->getShapeContent(), $time);
            foreach($subMotionContent->get() as $subData) {
                $offCenter = $preData->getOffCenter()->addVector($subData->getOffCenter());
                $content->put($subData->getShapeContent(), $offCenter, $time);
            }
        }
    }
}