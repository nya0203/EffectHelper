<?php

declare(strict_types=1);

namespace nya0203\effect;

use nya0203\content\effect\EffectContentCache;
use nya0203\effect\buffer\EffectBuffer;
use pocketmine\utils\ObjectSet;

class EffectPlayer {
    /** @phpstan-var ObjectSet<EffectHandler> */
    private ObjectSet $effects;
    private EffectBuffer $buffer;

    private EffectContentCache $cache;

    public function __construct() {
        $this->effects = new ObjectSet();
        $this->buffer = new EffectBuffer();
        $this->cache = new EffectContentCache();
    }

    private function addEffect(Effect $effect, EffectCenterVector $centerVector, array $viewers): EffectHandler {
        $handler =  new EffectHandler($effect, $centerVector, $viewers);
        $this->effects->add($handler);
        if(($cache = $this->cache->get($handler->getEffectId())) !== null)
            $handler->loadCache($cache);
        return $handler;
    }

    public function registerEffect(Effect $effect, EffectCenterVector $centerVector, array $viewers): EffectHandler {
        return $this->addEffect($effect, $centerVector, $viewers);
    }

    public function playEffect(EffectHandler $effect): void {
        if($effect->isCancelled() || $effect->isEnded())
            $this->effects->remove($effect);
        else {
            $effect->play($this->buffer);
            if(!$this->cache->contains(($effectId = $effect->getEffectId())))
                $this->cache->put($effectId, $effect->getContent());
        }
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