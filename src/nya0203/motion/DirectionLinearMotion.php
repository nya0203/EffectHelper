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
     * The afterimage interval is in meters.
     */
    public function __construct(private Vector3 $directionVector,
                                private float $speed,
                                private float|int|null $afterimageInterval = null) {
    }

    protected function write(MotionContent $content, ShapeContent $shapeContent, int $time): void {
        $center = new Vector3(0, 0 ,0);
        $directionVector = $this->directionVector;
        $distance = $directionVector->distance($center);
        if($distance > 0)
            $directionVector = $directionVector->divide($distance); // to unit vector
        $speed = $this->speed * 0.05; //to meter per tick.
        $interval = $this->afterimageInterval ?? abs($speed);
        $interval = $interval * ($speed / abs($speed));
        $beforeCount = floor($speed * ($time - 1) / $interval);
        for($count = 1; $count <= floor($speed * $time / $interval) - $beforeCount; $count++) {
            $beforeOffCenter = $directionVector->multiply($interval * $beforeCount);
            $vector = $directionVector->multiply($interval * $count);
            $content->put($shapeContent, $beforeOffCenter->addVector($vector), $time);
        }
    }
}