<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;
use nya0203\utils\RotationTypes;
use nya0203\utils\Utils;
use pocketmine\math\Vector3;

class ShapeShifter implements RotationTypes {

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

    public static function rotate(ShapeContent $shape, int $rotationType, int|float $angle, ?Vector3 $offset = null): ShapeContent {
        $content = new ShapeContent();
        $points = $shape->get();
        $offset = $offset ?? new Vector3(0,0,0);
        $matrix = Utils::getRotationMatrix($rotationType, $angle);
        foreach($points as $point) {
            $point = $point->addVector($offset);
            $d = [];
            foreach($matrix as $row)
                $d[] = $row[0] * $point->getX() + $row[1] * $point->getY() + $row[2] * $point->getZ();
            $point = new Vector3($d[0], $d[1], $d[2]);
            $content->putVector3($point->subtractVector($offset));
        }
        return $content;
    }

    public static function move(ShapeContent $shape, $x, $y, $z): ShapeContent {
        $content = new ShapeContent();
        $points = $shape->get();
        foreach($points as $point)
            $content->putVector3($point->add($x, $y, $z));
        return $content;
    }

    public static function rescale(ShapeContent $shape, $scale): ShapeContent {
        $content = new ShapeContent();
        $points = $shape->get();
        foreach($points as $point)
            $content->putVector3($point->multiply($scale));
        return $content;
    }

    private static function pointToString(Vector3 $point): string {
        return $point->x. ":". $point->y. ":". $point->z;
    }
}