<?php

declare(strict_types=1);

namespace nya0203\content\shape;

use pocketmine\math\Vector3;

class ShapeContent {
    /** @var Vector3[] */
    public array $content = [];

    public function put(int|float $x, int|float $y, int|float $z): void {
        $this->content[] = new Vector3($x, $y, $z);
    }

    public function putVector3(Vector3 $vector3): void {
        $this->content[] = $vector3;
    }

    /** @return Vector3[] */
    public function get(): array {
        return $this->content;
    }
}