<?php

declare(strict_types=1);

namespace nya0203\utils\color;

use pocketmine\color\Color;

class RandomColor implements EffectColor {
    public function __construct(private Color $minRangeColor,private Color $maxRangeColor) {
    }

    public function asColor(): Color {
        $r = mt_rand($this->minRangeColor->getR(), $this->maxRangeColor->getR());
        $g = mt_rand($this->minRangeColor->getG(), $this->maxRangeColor->getG());
        $b = mt_rand($this->minRangeColor->getB(), $this->maxRangeColor->getB());
        return new Color($r, $g, $b);
    }
}