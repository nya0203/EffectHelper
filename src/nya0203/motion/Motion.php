<?php

namespace nya0203\motion;



use nya0203\math\Vector4;
use nya0203\shape\Shape;

abstract class Motion {
    /** @var Vector4[]; */
    private array $points = [];

    protected abstract function calculation(array $points);

    protected function addResult(Vector4 $vector4): void {
        $this->points[] = $vector4;
    }

    /** @return Vector4[] */
    public function get(Shape $shape): array {
        if(empty($this->points))
            $this->calculation($shape->get());
        return $this->points;
    }
}