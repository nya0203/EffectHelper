<?php

declare(strict_types=1);

namespace nya0203\motion;

use nya0203\content\motion\MotionContent;
use nya0203\content\shape\ShapeContent;
use nya0203\shape\ShapeShifter;
use nya0203\utils\RotationTypes;
use nya0203\utils\Utils;
use pocketmine\math\Vector3;

class MotionShifter implements RotationTypes {
    public static function rotate(MotionContent $motion, int $rotationType, float|int $angle): MotionContent {
        $content = new MotionContent();
        $matrix = Utils::getRotationMatrix($rotationType, $angle);
        foreach($motion->get() as $contentData) {
            $shapeContent = ShapeShifter::rotate($contentData->getShapeContent(), $rotationType, $angle);
            $offCenter = $contentData->getOffCenter();
            $d = [];
            foreach($matrix as $row)
                $d[] = $row[0] * $offCenter->getX() + $row[1] * $offCenter->getY() + $row[2] * $offCenter->getZ();
            $content->put($shapeContent, new Vector3($d[0], $d[1], $d[2]), $contentData->getTime());
        }
        return $content;
    }

    public static function move(MotionContent $motion, float|int $x, float|int $y, float|int $z): MotionContent {
        $content = new MotionContent();
        foreach($motion->get() as $contentData) {
            $offCenter = $contentData->getOffCenter()->add($x, $y, $z);
            $content->put($contentData->getShapeContent(), $offCenter, $contentData->getTime());
        }
        return $content;
    }
}