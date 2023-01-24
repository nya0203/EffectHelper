<?php

declare(strict_types=1);

namespace nya0203\shape;

use nya0203\content\shape\ShapeContent;
use nya0203\utils\Utils;
use pocketmine\math\Vector3;

class BallShape extends Shape {
    public function __construct(private float|int $radius, private int $pointCount) {
    }

    public function write(ShapeContent $content): void {
        while(count($content->get()) < $this->pointCount) {
            $center = new Vector3(0, 0, 0);
            $point = new Vector3(Utils::random(-$this->radius, $this->radius),
                Utils::random(-$this->radius, $this->radius),
                Utils::random(-$this->radius, $this->radius));
            if($center->distance($point) <= $this->radius)
                $content->putVector3($point);
        }
    }
}