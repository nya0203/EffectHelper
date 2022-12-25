<?php

namespace nya0203\effect;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\world\particle\Particle;

class EffectMotionData {
    public function __construct(private Particle $particle, private Vector3 $vector) {
    }

    public function getParticle(): Particle {
        return $this->particle;
    }

    public function getVector(): Vector3 {
        return $this->vector;
    }

    public function getParticlePacket(Vector3 $center): ClientboundPacket {
        return $this->particle->encode($center->addVector($this->vector))[0];
    }
}