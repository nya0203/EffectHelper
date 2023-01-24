<?php

declare(strict_types=1);

namespace nya0203\utils\color;

use pocketmine\color\Color;

interface EffectColor {
    public function asColor(): Color;
}