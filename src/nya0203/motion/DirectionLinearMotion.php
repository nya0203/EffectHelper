<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;
use pocketmine\math\Vector3;

class DirectionLinearMotion extends Motion {

    /**
     * The direction vector is a unit vector representing only the direction.
     * But it doesn't have to be a unit vector.
     *
     * The speed is in m/s.
     * The duration is in seconds.
     * The afterimage interval is in meters.
     */
    public function __construct(private Vector3 $directionVector,
                                private float $speed,
                                private float|int $duration,
                                private float|int|null $afterimageInterval = null) {
    }

    protected function calculate(MotionContent $content, ShapeContent $shapeContent) {
        $center = new Vector3(0, 0 ,0);
        $directionVector = $this->directionVector;
        $distance = $directionVector->distance($center);
        if($distance > 0)
            $directionVector = $directionVector->divide($distance); // to unit vector
        $speed = $this->speed * 0.05; //to meter per tick.
        $duration = floor($this->duration / 0.05); // to tick.
        $interval = $this->afterimageInterval ?? $speed;
        $offCenter = $center;
        $vector = $directionVector->multiply($interval);
        for($tick = 0; $tick < $duration; $tick += $interval/$speed) {
            $content->put($shapeContent, $offCenter, (int)floor($tick));
            $offCenter = $offCenter->addVector($vector);
        }
    }
}