<?php

namespace nya0203\effect;

use nya0203\effect\buffer\EffectBuffer;
use nya0203\effect\EffectCache;
use pocketmine\math\Vector3;
use pocketmine\utils\ObjectSet;

class EffectPlayer {
    /** @phpstan-var ObjectSet<EffectHandler> */
    private ObjectSet $effects;
    private EffectBuffer $buffer;

    /** @var EffectCache[] */
    private array $cache = [];

    public function __construct() {
        $this->effects = new ObjectSet();
        $this->buffer = new EffectBuffer();
    }

    private function addEffect(Effect $effect, Vector3 $center, array $viewers): EffectHandler {
        $handler =  new EffectHandler($effect, $center, $viewers);
        $this->effects->add($handler);
        return $handler;
    }

    public function registerEffect(Effect $effect, Vector3 $center, array $viewers): EffectHandler {
        return $this->addEffect($effect, $center, $viewers);
    }

    public function playEffect(EffectHandler $effect): void {
        if($effect->isCancelled() || $effect->isEnded())
            $this->effects->remove($effect);
        else
            $effect->play($this->buffer);
    }

    public function playEffects(): void {
        foreach($this->effects as $effect)
            $this->playEffect($effect);
    }

    public function getBuffer(): EffectBuffer {
        $buffer = $this->buffer;
        $this->buffer = new EffectBuffer();
        return $buffer;
    }
}