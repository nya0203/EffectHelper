<?php

declare(strict_types=1);

namespace nya0203\content\effect;

use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ClientboundPacket;
use pocketmine\world\particle\Particle;

class EffectContentData {
    public function __construct(private Particle $particle, private Vector3 $vector) {
    }

    public function getParticle(): Particle {
        return $this->particle;
    }

    public function getVector(): Vector3 {
        return $this->vector;
    }

    /** @return ClientboundPacket[] */
    public function particleEncode(Vector3 $center): array {
        return $this->particle->encode($center->addVector($this->vector));
    }
}