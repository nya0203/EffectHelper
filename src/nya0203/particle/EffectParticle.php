<?php

namespace nya0203\particle;

use pocketmine\color\Color;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use pocketmine\network\mcpe\protocol\types\DimensionIds;
use pocketmine\world\particle\Particle;

abstract class EffectParticle implements Particle {

    protected abstract function jsonSerialize(): array;

    public abstract function getName(): string;

    public function encode(Vector3 $pos): array {
        return [SpawnParticleEffectPacket::create(
            dimensionId: DimensionIds::OVERWORLD,
            actorUniqueId: -1,
            position: $pos,
            particleName: $this->getName(),
            molangVariablesJson: json_encode($this->jsonSerialize())
        )];
    }
}