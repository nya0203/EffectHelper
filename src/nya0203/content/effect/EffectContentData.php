<?php

declare(strict_types=1);

namespace nya0203\content\effect;

use nya0203\effect\EffectCenterVector;
use nya0203\particle\EffectParticle;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ClientboundPacket;

class EffectContentData {
    public function __construct(private EffectParticle $particle, private Vector3 $vector) {
    }

    public function getParticle(): EffectParticle {
        return $this->particle;
    }

    public function getVector(): Vector3 {
        return $this->vector;
    }

    /** @return ClientboundPacket[] */
    public function getResult(EffectCenterVector $centerVector): array {
        $point = $this->vector->addVector($centerVector->getOffCenter());
        if($centerVector->getYaw() != 0 || $centerVector->getPitch() != 0)
            $point = $this->reposition($point, $centerVector->getCenter(), $centerVector->getYaw(), $centerVector->getPitch());
        return $this->particle->encode($point);
    }

    private function reposition(Vector3 $point, Vector3 $center, $yaw, $pitch): Vector3 {
        $point = $point->subtractVector($center);
        $yaw = deg2rad(270-$yaw);
        $pitch = deg2rad($pitch);
        $x = $point->getX();
        $y = $point->getY();
        $z = $point->getZ();
        $cos = cos($yaw);
        $sin = sin($yaw);
        $yx = $cos * $x + $sin * $z;
        $yz = -$sin * $x + $cos * $z;
        $cos = cos($pitch);
        $sin = sin($pitch);
        $px = $cos * $yx + -$sin * $y;
        $py = $sin * $yx + $cos * $y;
        return (new Vector3($px, $py, $yz))->addVector($center);
    }
}