<?php

declare(strict_types=1);

namespace nya0203\shape;

use pocketmine\math\Vector3;

class ShapeShifter {
    public Static function removeOverlapPoint(Shape $shape): Shape {
        $points = $shape->get();
        $points_map = [];
        foreach($points as $point)
            $points_map[self::pointToString($point)] = $point;
        return new FixedShape(array_values($points_map));
    }

    public static function rotate(Shape $shape, $x, $y, $z): Shape {

    }

    public static function move(Shape $shape, $x, $y, $z): Shape {

    }

    private static function pointToString(Vector3 $point): string {
        return $point->x. ":". $point->y. ":". $point->z;
    }
}