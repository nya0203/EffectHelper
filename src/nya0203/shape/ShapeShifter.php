<?php

namespace nya0203\shape;

use nya0203\shape\Shape;
use pocketmine\math\Vector3;

class ShapeShifter {
    public function removeOverlapPoint(Shape $shape): Shape {
        $points = $shape->get();
        $points_map = [];
        foreach($points as $point)
            $points_map[$this->pointToString($point)] = $point;
        return new FixedShape(array_values($points_map));
    }

    private function pointToString(Vector3 $point): string {
        return $point->x. ":". $point->y. ":". $point->z;
    }
}