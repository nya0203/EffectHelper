<?php

declare(strict_types=1);

namespace nya0203\utils\color;

use pocketmine\color\Color;

class MixEffectColor implements EffectColor {
    public function __construct(private Color|EffectColor $preColor, private Color|EffectColor $subColor, private float $ratio = 0.5) {
    }

    public function asColor(): Color {
        $preColor = $this->preColor;
        if($preColor instanceof EffectColor)
            $preColor = $this->preColor->asColor();
        $subColor = $this->subColor;
        if($subColor instanceof EffectColor)
            $subColor = $this->subColor->asColor();
        $preColorRatio = min(max($this->ratio, 0), 1);
        $subColorRatio = 1 - $preColorRatio;
        $r = ($preColor->getR() * $preColorRatio + $subColor->getR() * $subColorRatio);
        $g = ($preColor->getG() * $preColorRatio + $subColor->getG() * $subColorRatio);
        $b = ($preColor->getB() * $preColorRatio + $subColor->getB() * $subColorRatio);
        return new Color((int)$r, (int)$g, (int)$b);
    }
}