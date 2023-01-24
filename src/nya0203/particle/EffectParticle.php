<?php

namespace nya0203\particle;

use nya0203\utils\color\EffectColor;
use pocketmine\color\Color;
use pocketmine\math\Vector2;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\SpawnParticleEffectPacket;
use pocketmine\network\mcpe\protocol\types\DimensionIds;
use pocketmine\world\particle\Particle;

abstract class EffectParticle implements Particle {
    private Color|EffectColor $color;
    private Vector2 $uvPos;
    private float $motionSpeed;
    private Vector3 $motionAcc;
    private float $motionDrag;
    private Vector2 $particleSize;
    private float $lifetime;
    private float $particleCount;
    private float $emitterRadius;
    private float $frame;

    public function setColor(Color|EffectColor $color): void {
        $this->color = $color;
    }

    public function setUvPos(Vector2 $pos): void {
        $this->uvPos = $pos;
    }

    public function setMotionSpeed(float|int $speed): void {
        $this->motionSpeed = (float)$speed;
    }

    public function setMotionAcc(Vector3 $acc): void {
        $this->motionAcc = $acc;
    }

    public function setMotionDrag(float|int $drag): void {
        $this->motionDrag = (float)$drag;
    }

    public function setParticleSize(Vector2 $size): void {
        $this->particleSize = $size;
    }

    public function setLifetime(float|int $lifetime): void {
        $this->lifetime = (float)$lifetime;
    }

    public function setParticleCount(int $count): void {
        $this->particleCount = (float)$count;
    }

    public function setEmitterRadius(int|float $radius): void {
        $this->emitterRadius = (float)$radius;
    }

    public function setFrame(float|int $frame): void {
        $this->frame = (float)$frame;
    }

    public function getColor(): Color {
        $color = $this->color;
        if($color instanceof EffectColor)
            $color = $this->color->asColor();
        return $color;
    }

    public function getUvPos(): Vector2 {
        return $this->uvPos;
    }

    public function getMotionSpeed(): float {
        return $this->motionSpeed;
    }

    public function getMotionAcc(): Vector3 {
        return $this->motionAcc;
    }

    public function getMotionDrag(): float {
        return $this->motionDrag;
    }

    public function getParticleSize(): Vector2 {
        return $this->particleSize;
    }

    public function getLifetime(): float {
        return $this->lifetime;
    }

    public function getParticleCount(): float {
        return $this->particleCount;
    }

    public function getEmitterRadius(): float {
        return $this->emitterRadius;
    }

    public function getFrame(): float {
        return $this->frame;
    }

    public function jsonSerialize(): array {
        $color = $this->getColor();
        return [
            "size" => ['x'=> $this->getParticleSize()->getX(), 'y'=> $this->getParticleSize()->getY()],
            "lifetime"=> $this->getLifetime(),
            "emitter"=> [
                "count"=> $this->getParticleCount(),
                "radius"=> $this->getEmitterRadius(),
            ],
            "color"=> ['r'=> $color->getR(), 'g'=> $color->getG(), 'b'=> $color->getB()],
            "motion"=> [
                "speed"=> $this->getMotionSpeed(),
                "drag"=> $this->getMotionDrag(),
                "acc"=> ['x'=> $this->getMotionAcc()->getX(), 'y'=> $this->getMotionAcc()->getY(), 'z'=> $this->getMotionAcc()->getZ()]
            ],
            "uv"=> [
                "pos"=> ['x'=> $this->getUvPos()->getX(), 'y'=> $this->getUvPos()->getY()],
                "frame"=> $this->getFrame()
            ]
        ];
    }

    private function getMolangVariablesJson(): array {
        $color = $this->getColor();
        return [
            [
                "name" => "variable.count",
                "value" => [
                    "type" => "float",
                    "value" => $this->getParticleCount()
                ]
            ],
            [
                "name" => "variable.emitter_radius",
                "value" => [
                    "type" => "float",
                    "value" => $this->getEmitterRadius()
                ]
            ],
            [
                "name" => "variable.color",
                "value" => [
                    'type' => 'member_array',
                    'value' => [
                        [
                            "name" => ".r",
                            "value" => [
                                'type' => 'float',
                                'value' => $color->getR() / 255
                            ]
                        ],
                        [
                            "name" => ".g",
                            "value" => [
                                'type' => 'float',
                                'value' => $color->getG() / 255
                            ]
                        ],
                        [
                            "name" => ".b",
                            "value" => [
                                'type' => 'float',
                                'value' => $color->getB() / 255
                            ]
                        ]
                    ]
                ]
            ],
            [
                "name" => "variable.lifetime",
                "value" => [
                    'type' => 'float',
                    'value' => $this->getLifetime()
                ]
            ],
            [
                "name" => "variable.motion",
                "value" => [
                    'type' => 'member_array',
                    'value' => [
                        [
                            "name" => ".speed",
                            "value" => [
                                'type' => 'float',
                                'value' => $this->getMotionSpeed()
                            ]
                        ],
                        [
                            "name" => ".acc",
                            "value" => [
                                'type' => 'member_array',
                                'value' => [
                                    [
                                        "name" => ".x",
                                        "value" => [
                                            "type" => "float",
                                            "value" => (float)$this->getMotionAcc()->getX()
                                        ]
                                    ],
                                    [
                                        "name" => ".y",
                                        "value" => [
                                            "type" => "float",
                                            "value" => (float)$this->getMotionAcc()->getY()
                                        ]
                                    ],
                                    [
                                        "name" => ".z",
                                        "value" => [
                                            "type" => "float",
                                            "value" => (float)$this->getMotionAcc()->getZ()
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "name" => ".drag",
                            "value" => [
                                "type" => "float",
                                "value" => $this->getMotionDrag()
                            ]
                        ]
                    ]
                ]
            ],
            [
                "name" => "variable.uv",
                "value" => [
                    "type" => "member_array",
                    "value" => [
                        [
                            "name" => ".pos",
                            "value" => [
                                "type" => "member_array",
                                "value" => [
                                    [
                                        "name" => ".x",
                                        "value" => [
                                            "type" => "float",
                                            "value" => $this->getUvPos()->getX()
                                        ]
                                    ],
                                    [
                                        "name" => ".y",
                                        "value" => [
                                            "type" => "float",
                                            "value" => $this->getUvPos()->getY()
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        [
                            "name" => ".frame",
                            "value" => [
                                "type" => "float",
                                "value" => $this->getFrame()
                            ]
                        ]
                    ]
                ]
            ],
            [
                "name" => "variable.size",
                "value" => [
                    "type" => "member_array",
                    "value" => [
                        [
                            "name" => ".x",
                            "value" => [
                                "type" => "float",
                                "value" => $this->getParticleSize()->getX()
                            ]
                        ],
                        [
                            "name" => ".y",
                            "value" => [
                                "type" => "float",
                                "value" => $this->getParticleSize()->getY()
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    public function encode(Vector3 $pos): array {
        return [SpawnParticleEffectPacket::create(
            dimensionId: DimensionIds::OVERWORLD,
            actorUniqueId: -1,
            position: $pos,
            particleName: "effect:effect",
            molangVariablesJson: json_encode($this->getMolangVariablesJson())
        )];
    }
}