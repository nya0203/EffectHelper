<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;
use pocketmine\math\Vector3;

class ShapeShifter {
    public Static function removeOverlapPoint(ShapeContent $shape): ShapeContent {
        $content = new ShapeContent();
        $points = $shape->get();
        $checkedPoints = [];
        foreach($points as $point) {
            $toString = self::pointToString($point);
            if(in_array($toString, $checkedPoints) === true)
                continue;
            $content->putVector3($point);
            $checkedPoints[] = $toString;
        }
        return $content;
    }

    public static function rotate(Shape $shape, $x, $y, $z): Shape {

    }

    public static function move(Shape $shape, $x, $y, $z): Shape {

    }

    private static function pointToString(Vector3 $point): string {
        return $point->x. ":". $point->y. ":". $point->z;
    }
}