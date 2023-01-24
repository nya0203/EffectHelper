<?php

declare(strict_types=1);

namespace nya0203\utils\color;

use pocketmine\color\Color;

class RandomBrightnessColor implements EffectColor {
    public function __construct(private int $minBrightness, private int $maxBrightness) {
    }

    public function asColor(): Color {
        $brightness = mt_rand($this->minBrightness, $this->maxBrightness);
        return new Color($brightness, $brightness, $brightness);
    }
}