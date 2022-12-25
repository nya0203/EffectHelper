<?php

declare(strict_types=1);

namespace nya0203\shape;

use pocketmine\math\Vector3;

class FixedShape extends Shape {
    /** @param Vector3[] $points */
    public function __construct(private array $points) {
    }

    protected function calculation() {
    }
}