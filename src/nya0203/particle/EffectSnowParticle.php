<?php

namespace nya0203\particle;

use pocketmine\color\Color;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use pocketmine\network\mcpe\protocol\types\DimensionIds;
use pocketmine\world\particle\Particle;

class EffectSnowParticle extends EffectParticle {
    public function __construct(private Color $color) {}

    protected function jsonSerialize(): array {
        return [
            [
                "name" => "variable.r",
                "value" => [
                    'type' => 'float',
                    'value' => $this->color->getR() / 255
                ]
            ],
            [
                "name" => "variable.g",
                "value" => [
                    'type' => 'float',
                    'value' => $this->color->getG() / 255
                ]
            ],
            [
                "name" => "variable.b",
                "value" => [
                    'type' => 'float',
                    'value' => $this->color->getB() / 255
                ]
            ]
        ];
    }

    public function getName(): string {
        return "minecraft:effect_snow";
    }
}