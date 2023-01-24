<?php

namespace nya0203\particle;

use nya0203\utils\color\EffectColor;
use nya0203\utils\Utils;
use pocketmine\color\Color;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;

class EffectDustParticle extends EffectParticle {
    public function __construct(Color|EffectColor $color, private float $baseSize, float|int $lifetime = 0.5) {
        $this->setColor($color);
        $this->setFrame(8);
        $this->setLifetime($lifetime);
        $this->setMotionAcc(new Vector3(0, 0.2, 0));
        $this->setMotionSpeed(0);
        $this->setMotionDrag(0);
        $this->setParticleCount(1);
        $this->setEmitterRadius(0);
    }

    public function getUvPos(): Vector2 {
        return new Vector2(mt_rand(7, 8) * 8, 0);
    }

    public function getParticleSize(): Vector2 {
        $size = $this->baseSize + Utils::random($this->baseSize * 0.01, $this->baseSize);
        return new Vector2($size, $size);
    }
}
