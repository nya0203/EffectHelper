<?php

namespace nya0203\particle;

use nya0203\utils\color\EffectColor;
use pocketmine\color\Color;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;

class EffectSpell2Particle extends EffectParticle {
    public function __construct(Color|EffectColor $color, float $size, float|int $lifetime = 0.5) {
        $this->setColor($color);
        $this->setFrame(0);
        $this->setLifetime($lifetime);
        $this->setMotionAcc(new Vector3(0, 0, 0));
        $this->setMotionSpeed(0);
        $this->setMotionDrag(0);
        $this->setUvPos(new Vector2(40, 88));
        $this->setParticleSize(new Vector2($size, $size));
        $this->setParticleCount(1);
        $this->setEmitterRadius(0);
    }
}