<?php

declare(strict_types=1);

namespace nya0203\shape;

use pocketmine\math\Vector3;

abstract class Shape {
    /** @var Vector3[] */
    private array $points = [];

    protected abstract function calculation();

    protected function addResult(Vector3 $vector3): void {
        $this->points[] = $vector3;
    }

    /** @return Vector3[] */
    public function get(): array {
        if(empty($this->points))
            $this->calculation();
        return $this->points;
    }
}