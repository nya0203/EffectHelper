<?php

declare(strict_types=1);

namespace nya0203\effect;

use pocketmine\math\Vector3;

class EffectCenterVector {
    public function __construct(private Vector3 $center, private float|int $yaw = 0, private float|int $pitch = 0, private ?Vector3 $offset = null) {
        $this->offset = $this->offset ?? new Vector3(0, 0, 0);
    }

    public function getCenter(): Vector3 {
        return $this->center;
    }

    public function getOffset(): Vector3 {
        return $this->offset;
    }

    public function getOffCenter(): Vector3 {
        return $this->center->addVector($this->offset);
    }

    public function getYaw(): float|int {
        return $this->yaw;
    }

    public function getPitch(): float|int {
        return $this->pitch;
    }

    public function setCenter(Vector3 $center): EffectCenterVector {
        return new EffectCenterVector($center, $this->yaw, $this->pitch, $this->offset);
    }

    public function setOffset(Vector3 $offset): EffectCenterVector {
        return new EffectCenterVector($this->center, $this->yaw, $this->pitch, $offset);
    }

    public function setYaw(float|int $yaw): EffectCenterVector {
        return new EffectCenterVector($this->center, $yaw, $this->pitch, $this->offset);
    }

    public function setPitch(float|int $pitch): EffectCenterVector {
        return new EffectCenterVector($this->center, $this->yaw, $pitch, $this->offset);
    }
}